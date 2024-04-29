$(document).ready(function() {
    // Faire une requête AJAX pour obtenir les informations de l'équipe de l'utilisateur lors du chargement de la page
    $.ajax({
        url: '../controller/get_team.php',  // URL du script PHP qui va interroger la base de données
        type: 'POST',
        data: {
            ownerid: userId,  // Envoyer l'ID de l'utilisateur au script PHP
        },
        success: function(data) {
            // Les données reçues du serveur seront une chaîne JSON.
            // Nous devons la convertir en un objet JavaScript pour pouvoir l'utiliser.
            var team = JSON.parse(data);

            // Parcourir tous les postes de l'équipe
            for (var position in team) {
                // Vérifier si un joueur a été assigné à ce poste
                if (team[position] !== null) {
                    // Trouver le bouton correspondant à ce poste
                    var addButton = document.getElementById(position);

                    // Remplacer le contenu du bouton par les informations du joueur
                    $(addButton).html(`
                        <div class="player-added">
                            <div class="player-image-added">
                                <img src="${team[position].faceLink}" alt="Face">
                                <img src="${team[position].eyebrowsLink}" alt="Eyebrows">
                                <img src="${team[position].eyesLink}" alt="Eyes">
                                <img src="${team[position].mouthLink}" alt="Mouth">
                                <img src="${team[position].noseLink}" alt="Nose">
                            </div>
                            <div class="player-score-added" style="background-color:${team[position].scoreColor};">
                                <p>${team[position].score}</p>
                            </div>
                            <div class="player-total-score-added" style="background-color:${team[position].totalScoreColor};">
                                <p>${team[position].totalScore}</p>
                            </div>
                        </div>
                    `);
                }
            }
        }
    });
});
