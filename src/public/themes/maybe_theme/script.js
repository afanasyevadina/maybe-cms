document.querySelectorAll('.accordion-title').forEach(el => el.onclick = (event) => {
    event.preventDefault()
    el.classList.toggle('open')
})
