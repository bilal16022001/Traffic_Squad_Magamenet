

document.querySelectorAll(".delet").forEach(el => {
    el.addEventListener("click", () => {
        window.confirm("are you sure to delet ?")
    })
})
