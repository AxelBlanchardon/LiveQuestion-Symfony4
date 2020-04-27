function onClickbtnLike(event) {
    event.preventDefault(); // annule l'évenement lors du click (comportement par défaut de redirection par le lien a href)

    const url = this.href; // this a pour valeur l'élément html qui declenche l'évenement (ici a href)
    const spanCount = this.querySelector('span.js-likes');
    const icone = this.querySelector('i');

    axios.get(url).then(function(response){ // response contient les datas que le serveur répond en format json
        spanCount.textContent = response.data.likes;

        if(icone.classList.contains('fas')){
            icone.classList.replace('fas', 'far'); // replace le pouce rempli (fas) par le pouce vide (far)
        } else {
            icone.classList.replace('far', 'fas');
        }
    })
}

document.querySelectorAll('a.js-like').forEach(function(link){  // sélectionne tout les a correspondant à la classe js-like et boucle sur chacuns des liens a
    link.addEventListener('click', onClickbtnLike);             // listener sur l'action click qui appelle la fonction onClickbtnLike (fonction définie plus haut)
})

