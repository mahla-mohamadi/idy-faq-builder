const accordionItems = document.querySelectorAll('.accordion-item');

accordionItems.forEach((item) => {
  const header = item.querySelector('.line');
  const icon = item.querySelector('.svg');

  header.addEventListener('click', () => {
    const isOpen = item.classList.contains('active');

    accordionItems.forEach((i) => {
      i.classList.remove('active');
      const svg = i.querySelector('.svg');
      svg.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
          <path d="M5 12h14"/>
          <path d="M12 5v14"/>
        </svg>
      `;
    });

    if (!isOpen) {
      item.classList.add('active');
      icon.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus">
          <path d="M5 12h14"/>
        </svg>
      `;
    }
  });
});

