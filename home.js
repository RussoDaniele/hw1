function onSaved(){
    const save = document.querySelector('.svbutton p');
    save.innerText = 'Salvato';
    const savebtn = document.querySelector('.svbutton');
    savebtn.removeEventListener('click', saveMovie);
}

function onError(){
    console.log("Errore durante il salvataggio");
}

function dbResponse(json){
    if(!json.ok){
        onError();
        return null;
    }
}

function sonResponse(response){
    console.log(response);
    return response.json().then(dbResponse);
}

function saveMovie(event){
    console.log("Salvataggio")

    const result = document.querySelector('.result');
    const formData = new FormData();
    formData.append('image', result.dataset.image);
    formData.append('title', result.dataset.title);
    formData.append('genre', result.dataset.genre);
    formData.append('runtime', result.dataset.runtime);
    formData.append('cast', result.dataset.cast);
    formData.append('plot', result.dataset.plot);
    fetch("save_movie.php", {method: 'post', body: formData}).then(sonResponse).then(onSaved);
    event.stopPropagation();
}

function noResult(){
    const res_container = document.getElementById('res-container');
    res_container.innerHTML = '';
    const noresult = document.createElement('div');
    noresult.className = "no-result";
    noresult.textContent = "Nessun risultato.";
    res_container.appendChild(noresult);
}

function jsonMovie(json){
    console.log(json);

    const res_container = document.getElementById('res-container');
    res_container.innerHTML = '';
    if (json == null){
        noResult();
        return;
    }

    const result = document.createElement('div');
    result.classList.add('result');
    result.dataset.image = json.Poster;
    result.dataset.title = json.Title;
    result.dataset.genre = json.Genre;
    result.dataset.runtime = json.Runtime;
    result.dataset.cast = json.Actors;
    result.dataset.plot = json.Plot;

    const left = document.createElement('div');
    left.classList.add('left');
    const right = document.createElement('div');
    right.classList.add('right');
    result.appendChild(left);
    result.appendChild(right);

    const img = document.createElement('img');
    img.src = json.Poster;
    left.appendChild(img);

    const title = document.createElement('h2');
    title.innerText = json.Title;
    const genre = document.createElement('h3');
    genre.innerText = 'Genre: '+json.Genre;
    const time = document.createElement('h3');
    time.innerText = 'Runtime: '+json.Runtime;
    const cast = document.createElement('h3');
    cast.innerText = 'Cast: '+json.Actors;
    const plot = document.createElement('p');
    plot.innerText = json.Plot;
    right.appendChild(title);
    right.appendChild(genre);
    right.appendChild(time);
    right.appendChild(cast);
    right.appendChild(plot);
    
    const btn_container = document.createElement('div');
    btn_container.classList.add("container");
    result.appendChild(btn_container);
    
    const savebtn = document.createElement('div');
    savebtn.classList.add("svbutton");
    btn_container.appendChild(savebtn);
    const save = document.createElement('p');
    save.innerText= "+ Lista Da guardare"
    savebtn.appendChild(save);

    savebtn.addEventListener('click', saveMovie);

    res_container.appendChild(result);
}

function onResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function Search(event){
    const search = document.querySelector('.search input');
    fetch("search_movie.php?q="+encodeURIComponent(search.value)).then(onResponse).then(jsonMovie);
    event.preventDefault();
}

document.querySelector("#search form").addEventListener("submit", Search);