shareButton = document.getElementById("shareBill");

  shareButton.addEventListener('click', event => {
    if (navigator.share) {
      navigator.share({
        title: 'Facture Commande n°'+ $("#shareBill").val(),
        text: 'Commande n°'+$("#shareBill").val()+ '. ' + $("#shareBill").data('desc')+ '. '+ $("#shareBill").data('adresse')+ '. Contact:'+ $("#shareBill").data('phone') +'. Total:' +$("#shareBill").data('total')+'. cliquez ici pour le tracking.',
        url: 'https://client.livreurjibiat.site/tracking/'+ $("#shareBill").val()
      }).then(() => {
        console.log('Thanks for sharing!');
      })
      .catch(console.error);
    } else {
      shareDialog.classList.add('is-open');
    }
  });
