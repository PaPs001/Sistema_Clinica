export function openOtherSpaces({
    buttons,
    sections
}){
    const bttns = document.querySelectorAll(buttons);
    const sect = document.querySelectorAll(sections);

    bttns.forEach(btn => {
        btn.addEventListener("click", () => {
            bttns.forEach(b => b.classList.remove("active"));
            sect.forEach(s => s.classList.remove("active"));

            btn.classList.add("active");
            const tabId = btn.getAttribute("data-tab");
            document.getElementById(tabId).classList.add("active");
        })
    })
}