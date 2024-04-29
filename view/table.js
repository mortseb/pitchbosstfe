$(document).ready(function() {
    if (!$.fn.dataTable.isDataTable('.player-table')) {
        var table = $('.player-table').DataTable({
            responsive: true
        });

        var currentOrder = [0, 'desc']; // Ordre de tri initial

        // Écoute les modifications du menu déroulant
        $('#sortColumn').change(function() {
            var columnNum = $(this).val();

            // Trie la colonne sélectionnée avec l'ordre de tri actuel
            table.order([columnNum, currentOrder[1]]).draw();

            // Supprime la classe de tri de la colonne précédente
            $('.player-table thead th').removeClass('column-sort');

            // Ajoute la classe de tri à la colonne actuelle
            $('.player-table thead th').eq(columnNum).addClass('column-sort');
        });

        // Écoute les clics sur les en-têtes de colonne pour trier les colonnes
        $('.player-table thead th').on('click', function() {
            var columnNum = $(this).index();

            // Vérifie si la colonne est déjà triée
            if (currentOrder[0] === columnNum) {
                // Inverse l'ordre de tri
                currentOrder[1] = currentOrder[1] === 'desc' ? 'asc' : 'desc';
            } else {
                // Réinitialise l'ordre de tri à ascendant
                currentOrder = [columnNum, 'desc'];
            }

            // Trie la colonne avec l'ordre de tri actuel
            table.order(currentOrder).draw();

            // Supprime la classe de tri de la colonne précédente
            $('.player-table thead th').removeClass('column-sort');

            // Ajoute la classe de tri à la colonne actuelle
            $(this).addClass('column-sort');
        });
    }
});
