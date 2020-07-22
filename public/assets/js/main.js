console.log("main.js chargé...");

// CODE JS POUR LIGHTBOX
// ON VA AJOUTER UNE ACTION SUR LES IMAGES DANS LES ARTICLES

function ajouterAction (selecteurCSS, evenementJS, callback)
{
    var listeBalise = document.querySelectorAll(selecteurCSS);
    for(var b=0; b<listeBalise.length; b++)
    {
        var balise = listeBalise[b];
        balise.addEventListener(evenementJS, callback);
    }
}

// C'EST JAVASCRIPT QUI FOURNIT L'OBJET event
// => ON N'A PAS A LE CREER
// => INJECTION DE DEPENDANCE
function afficherLightbox (event)
{
    console.log(event.target);

    // AFFICHER LA LIGHTBOX AVEC IMAGE EN GRAND DEDANS
    var baliseLightbox = document.querySelector(".lightbox");
    if (baliseLightbox != null)
    {
        var imgGrand = baliseLightbox.querySelector("img");
        imgGrand.src = event.target.src;
        baliseLightbox.classList.add('afficher');
    }
}
function cacherLightbox (event)
{
    var baliseLightbox = document.querySelector(".lightbox");
    if (baliseLightbox != null)
    {
        baliseLightbox.classList.remove('afficher');
    }
}
ajouterAction("article img", "click", afficherLightbox);
ajouterAction(".lightbox", "click", cacherLightbox);
