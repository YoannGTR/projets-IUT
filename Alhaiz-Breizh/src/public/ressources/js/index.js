function scrollToLeft(elementSelector) {
    const element = document.querySelector(elementSelector);
    const distance = 290; // Ajustez la distance à déplacer
  
    let currentScroll = element.scrollLeft;
    let targetScroll = element.scrollLeft - distance;
  
    const scrollStep = 10; // Ajustez le pas de défilement pour la fluidité
    const steps = Math.abs(targetScroll - currentScroll) / scrollStep;
  
    let i = 0;
    const animation = setInterval(() => {
      if (i >= steps) {
        clearInterval(animation);
        return;
      }
  
      currentScroll = Math.floor(currentScroll + (targetScroll - currentScroll) * (i / steps));
      element.scrollTo({ left: currentScroll });
      i++;
    }, 10); // Ajustez l'intervalle pour la vitesse d'animation (en millisecondes)
  }
  
  function scrollToRight(elementSelector) {
    const element = document.querySelector(elementSelector);
    const distance = 290; // Ajustez la distance à déplacer
  
    let currentScroll = element.scrollLeft;
    let targetScroll = element.scrollLeft + distance;
  
    const scrollStep = 10; // Ajustez le pas de défilement pour la fluidité
    const steps = Math.abs(targetScroll - currentScroll) / scrollStep;
  
    let i = 0;
    const animation = setInterval(() => {
      if (i >= steps) {
        clearInterval(animation);
        return;
      }
  
      currentScroll = Math.floor(currentScroll + (targetScroll - currentScroll) * (i / steps));
      element.scrollTo({ left: currentScroll });
      i++;
    }, 10); // Ajustez l'intervalle pour la vitesse d'animation (en millisecondes)
  }