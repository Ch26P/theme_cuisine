// ouverture Modal Contact au menu
jQuery(document).ready(function ($) {

    //  var referenceValue = jQuery("nav #connect").html();
    console.log("bonjour");
    console.log($("nav #connect"));
    console.log($('#bloc_login '));
    //   console.log($('.modale_contact'));
    $('nav #connect .connect_out').click(function () {
        $('#bloc_login').slideToggle();

        //    $('#ref').val(referenceValue);

    });

   // Afficher ou masquer le calendrier
   $('#view-calendar').click(function () {
    $('#calendar-overlay, #calendar-container').fadeIn(); // Affiche l'overlay et le calendrier
});

// Fermer le calendrier
$('#close-calendar').click(function () {
    $('#calendar-overlay, #calendar-container').fadeOut(); // Masque l'overlay et le calendrier
});

// Fermer le calendrier lorsque l'utilisateur clique sur l'overlay
$('#calendar-overlay').click(function () {
    $('#calendar-overlay, #calendar-container').fadeOut(); // Masque l'overlay et le calendrier
});


});