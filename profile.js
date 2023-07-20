fetchMovies();

function noSavedMovies() {
    const res_container = document.getElementById('res-container');
    res_container.innerHTML = '';
    const nosaved = document.createElement('div');
    nosaved.className = "no-result";
    nosaved.textContent = "Nessun elemento salvato.";
    res_container.appendChild(nosaved);
}

function jsonFetch(json){
    console.log("Eseguo FetchMovies");
    console.log(json);
    if (!json){
        noSavedMovies();
        return;
    }
    
    const res_container = document.getElementById('res-container');
    res_container.innerHTML = '';

    for (let movie in json) {
        const result = document.createElement('div');
        result.dataset.id = json[movie].id;
        result.classList.add('result');

        const movies = document.querySelectorAll(".result");

        const left = document.createElement('div');
        left.classList.add('left');
        const right = document.createElement('div');
        right.classList.add('right');
        result.appendChild(left);
        result.appendChild(right);

        const img = document.createElement('img');
        img.src = json[movie].image;
        left.appendChild(img);

        const title = document.createElement('h2');
        title.innerText = json[movie].title;
        const genre = document.createElement('h3');
        genre.innerText = 'Genre: '+json[movie].genre;
        const time = document.createElement('h3');
        time.innerText = 'Runtime: '+json[movie].runtime;
        const cast = document.createElement('h3');
        cast.innerText = 'Cast: '+json[movie].cast;
        const plot = document.createElement('p');
        plot.innerText = json[movie].plot;
        right.appendChild(title);
        right.appendChild(genre);
        right.appendChild(time);
        right.appendChild(cast);
        right.appendChild(plot);

        res_container.appendChild(result);
    }
}

function onResponse(response) {
    if (!response.ok){
        return null;
    }

    return response.json();
}

function fetchMovies(){
    fetch("fetch_movies.php").then(onResponse).then(jsonFetch);
}
