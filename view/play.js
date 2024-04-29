function getRatingColor(rating) {
    if (rating >= 1 && rating < 20) {
        return '#FF3131';
    } else if (rating >= 20 && rating < 40) {
        return '#FF5757';
    } else if (rating >= 40 && rating < 60) {
        return '#FFBD59';
    } else if (rating >= 60 && rating < 70) {
        return '#C1FF72';
    } else if (rating >= 70 && rating < 80) {
        return '#7ED957';
    } else if (rating >= 80 && rating < 90) {
        return '#00BF63';
    } else if (rating >= 90 && rating <= 100) {
        return '#5CE1E6';
    } else {
        return '#ccc';
    }
}

function updateAveragesAndTotals() {
    // Calculate the average goalkeeper score
    var totalGK = 0;
    var gkPlayers = $('.gkcontainer .player-score-added p');
    for (var i = 0; i < gkPlayers.length; i++) {
        totalGK += parseInt(gkPlayers.eq(i).text());
    }
    var avgGK = totalGK / gkPlayers.length;

    // Calculate the average defender score
    var totalDEF = 0;
    var defPlayers = $('.defcontainer .player-score-added p');
    for (var i = 0; i < defPlayers.length; i++) {
        totalDEF += parseInt(defPlayers.eq(i).text());
    }
    var avgDEF = totalDEF / defPlayers.length;

    // Calculate the average midfielder score
    var totalMID = 0;
    var midPlayers = $('.midcontainer .player-score-added p');
    for (var i = 0; i < midPlayers.length; i++) {
        totalMID += parseInt(midPlayers.eq(i).text());
    }
    var avgMID = totalMID / midPlayers.length;

    // Calculate the average attacker score
    var totalATK = 0;
    var atkPlayers = $('.atkcontainer .player-score-added p');
    for (var i = 0; i < atkPlayers.length; i++) {
        totalATK += parseInt(atkPlayers.eq(i).text());
    }
    var avgATK = totalATK / atkPlayers.length;

    // Calculate the average total score for all players
    var totalTotalScore = 0;
    var totalScorePlayers = $('.player-total-score-added p');
    for (var i = 0; i < totalScorePlayers.length; i++) {
        totalTotalScore += parseInt(totalScorePlayers.eq(i).text());
    }
    var avgTotalScore = totalTotalScore / totalScorePlayers.length;
// Mise à jour des scores moyens dans la vue
$('#avgGK').text(Math.round(avgGK)).css('background-color', getRatingColor(avgGK));
$('#avgDEF').text(Math.round(avgDEF)).css('background-color', getRatingColor(avgDEF));
$('#avgMID').text(Math.round(avgMID)).css('background-color', getRatingColor(avgMID));
$('#avgATK').text(Math.round(avgATK)).css('background-color', getRatingColor(avgATK));
$('#avgTotalScore').text(Math.round(avgTotalScore)).css('background-color', getRatingColor(avgTotalScore));

    // Perform AJAX request to update the team averages in the database
    $.ajax({
        url: '../controller/update_averages.php',
        type: 'POST',
        data: {
            avgGK: avgGK,
            avgDEF: avgDEF,
            avgMID: avgMID,
            avgATK: avgATK,
            avgTotalScore: avgTotalScore,
        },
        success: function(response) {
            // Handle the success response, if needed
        },
        error: function(xhr, status, error) {
            // Handle the error, if needed
        }
    });
}


var userId = $('meta[name="user-id"]').attr('content');

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementsByClassName("addplayer");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
for (var i = 0; i < btn.length; i++) {
    btn[i].onclick = function() {
        modal.style.display = "block";
    }
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Récupérer les éléments addplayer
var addPlayers = document.getElementsByClassName('addplayer');

// Parcourir tous les éléments addplayer
for(var i = 0; i < addPlayers.length; i++) {

    // Ajouter un écouteur d'événements à chaque élément addplayer
    addPlayers[i].addEventListener('click', function(event) {
        event.preventDefault();

        // Récupérer le type de joueur (gardien, defenseur, milieu, attaquant)
        var playerType = this.classList[1];
        var addButton = this;  // Enregistrer une référence à l'élément bouton

        // Appeler une fonction AJAX pour récupérer les données du serveur
        $.ajax({
            url: '../controller/fetch_players.php',  // URL du script PHP qui va interroger la base de données
            type: 'POST',
            data: {
                type: playerType,    // Envoyer le type de joueur au script PHP
            },
            success: function(data) {
                // Insérer les données dans la fenêtre modale
                $('.modal-content').html(data);

                // Ajouter un écouteur d'événements à chaque joueur
                $('.player').click(function() {
                    // Récupérer les informations du joueur
                    var playerInfo = {
                        id: $(this).data('id'),  // Ajouter data-id dans le HTML généré par PHP
                        faceLink: $(this).find('.player-image img:nth-child(1)').attr('src'),
                        eyebrowsLink: $(this).find('.player-image img:nth-child(2)').attr('src'),
                        eyesLink: $(this).find('.player-image img:nth-child(3)').attr('src'),
                        mouthLink: $(this).find('.player-image img:nth-child(4)').attr('src'),
                        noseLink: $(this).find('.player-image img:nth-child(5)').attr('src'),
                        score: $(this).find('.player-score p').text(),
                        scoreColor: $(this).find('.player-score').css('background-color'),
                        totalScore: $(this).find('.player-total-score p').text(),
                        totalScoreColor: $(this).find('.player-total-score').css('background-color'),
                    };

                    // Fermer la fenêtre modale
                    $('#myModal').modal('hide');

                    // Insérer le joueur dans le bouton
                    $(addButton).html(`
                        <div class="player-added">
                            <div class="player-image-added">
                                <img src="${playerInfo.faceLink}" alt="Face">
                                <img src="${playerInfo.eyebrowsLink}" alt="Eyebrows">
                                <img src="${playerInfo.eyesLink}" alt="Eyes">
                                <img src="${playerInfo.mouthLink}" alt="Mouth">
                                <img src="${playerInfo.noseLink}" alt="Nose">
                            </div>
                            <div class="player-score-added" style="background-color:${playerInfo.scoreColor};">
                                <p>${playerInfo.score}</p>
                            </div>
                            <div class="player-total-score-added" style="background-color:${playerInfo.totalScoreColor};">
                                <p>${playerInfo.totalScore}</p>
                            </div>
                        </div>
                    `);

                    // Faire une requête AJAX pour mettre à jour la table de l'équipe
                    $.ajax({
                        url: '../controller/update_team.php',  // URL du script PHP qui va mettre à jour la table de l'équipe
                        type: 'POST',
                        data: {
                            ownerid: userId,
                            playerid: playerInfo.id,
                            position: addButton.id,  // Utiliser l'id du bouton comme le poste
                        },
                        success: function() {
                            // Mettre à jour les moyennes et les totaux
                            updateAveragesAndTotals();
                        }
                    }); // Fermeture du bloc AJAX
                }); // Fermeture du bloc .click

                // Ouvrir la fenêtre modale
                $('#myModal').modal('show');
            } // Fermeture du bloc success de la première requête AJAX
        }); // Fermeture du bloc AJAX
    }); // Fermeture du bloc .addEventListener
} // Fermeture du bloc for

$(document).ready(function() {
    // Effectuer une requête AJAX pour récupérer les données de l'équipe
    $.ajax({
        url: '../controller/fetch_team.php',  // URL du script PHP qui va interroger la base de données
        type: 'POST',
        dataType: 'json',
        data: {
            ownerid: userId,
        },
        success: function(data) {
            // Parcourir les données de l'équipe
            for(var i = 0; i < data.length; i++) {
                // Récupérer les informations du joueur et la position
                var playerInfo = data[i].player;
                var position = data[i].position;

                // Vérifier si playerInfo est null (ce qui signifie qu'il s'agit de l'entrée des moyennes)
                if (playerInfo == null) {
                    // Mettre à jour les div avec les moyennes
                    $('#avgGK').text(data[i].averages.avgGK).css('background-color', getRatingColor(data[i].averages.avgGK));
                    $('#avgDEF').text(data[i].averages.avgDEF).css('background-color', getRatingColor(data[i].averages.avgDEF));
                    $('#avgMID').text(data[i].averages.avgMID).css('background-color', getRatingColor(data[i].averages.avgMID));
                    $('#avgATK').text(data[i].averages.avgATK).css('background-color', getRatingColor(data[i].averages.avgATK));
                    $('#avgTotalScore').text(data[i].averages.avgTotalScore).css('background-color', getRatingColor(data[i].averages.avgTotalScore));
                } else {
                    // Déterminer le score à afficher en fonction de la position
var score;
switch (position) {
    case 'gk1':
        score = playerInfo.noteGardien;
        break;
    case 'def1':
    case 'def2':
    case 'def3':
    case 'def4':
        score = playerInfo.noteDefenseur;
        break;
    case 'mid1':
    case 'mid2':
    case 'mid3':
        score = playerInfo.noteMilieu;
        break;
    case 'atk1':
    case 'atk2':
    case 'atk3':
        score = playerInfo.noteAttaquant;
        break;
    default:
        score = 'N/A';
}

// Trouver le bouton correspondant à la position
var addButton = $('#' + position);

// Mettre à jour le bouton avec les informations du joueur
$(addButton).html(`
    <div class="player-added">
        <div class="player-image-added">
            <img src="${playerInfo.faceLink}" alt="Face">
            <img src="${playerInfo.eyebrowsLink}" alt="Eyebrows">
            <img src="${playerInfo.eyesLink}" alt="Eyes">
            <img src="${playerInfo.mouthLink}" alt="Mouth">
            <img src="${playerInfo.noseLink}" alt="Nose">
        </div>
        <div class="player-score-added" style="background-color:${getRatingColor(score)};">
            <p>${score}</p>
        </div>
        <div class="player-total-score-added" style="background-color:${getRatingColor(playerInfo.totalscore)};">
            <p>${playerInfo.totalscore}</p>
        </div>
    </div>
`);

                }
            }
        }
    }); // Fermeture du bloc AJAX
}); // Fermeture du bloc $(document).ready
$('.player-info').on({
    mouseenter: function () {
        // Get player's information
        var playerName = $(this).find('.player-name').text();
        var playerScore = $(this).find('.player-score p').text();
        var playerTotalScore = $(this).find('.player-total-score p').text();

        // Create tooltip div
        var tooltip = $(
            `<div class="tooltip">
                <p>Name: ${playerName}</p>
                <p>Score: ${playerScore}</p>
                <p>Total Score: ${playerTotalScore}</p>
            </div>`
        );

        // Add tooltip to player div
        $(this).append(tooltip);
    },
    mouseleave: function () {
        // Remove tooltip
        $(this).find('.tooltip').remove();
    }
});
