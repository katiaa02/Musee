document.getElementById('next').onclick = function(){
    let lists = document.querySelectorAll('.item');
    document.getElementById('slide').appendChild(lists[0]);
}
document.getElementById('prev').onclick = function(){
    let lists = document.querySelectorAll('.item');
    document.getElementById('slide').prepend(lists[lists.length - 1]);
}

function showMuseums() {
    const selectedCity = document.getElementById('citySelect').value;
    // Rediriger vers la deuxième page avec la ville sélectionnée
    window.location.href = `page2.php?city=${selectedCity}`;
}