const upcomingForm = document.getElementById("add-upcoming-form");
const formInput = document.querySelector(".upcoming-input");
const formHiddenBtn = document.getElementById("hidden-btn");


const upcomingList = document.querySelector(".upcoming-list");
const upcomingListItems = document.querySelectorAll(".upcoming-list li");

const deleteBtn =  document.querySelector(".delete-upcoming");

let upcomingTasks;

// console.log(moveForm);_




function fetchtUpcoming(id) {
    fetch(`http://localhost:7000/upcoming_project?id=${id}`)
    .then (res => res.json())
    .then((datas) => {

        upcomingTasks = datas;

        if (datas.length == "" ) {
            const notFoundList = document.createElement('li');
            upcomingList.className = "p-4 alert alert-danger my-2";
            notFoundList.className = 'd-flex justify-content-between align-items-center';
            notFoundList.textContent = "No upcoming tasks found, please add upcoming task";
            upcomingList.appendChild(notFoundList);

        }
        datas.forEach((data) => {
            const listItem = document.createElement('li');
            const todo = document.createElement('div');
            const form = document.createElement('form');
            const formCheck = document.createElement('div');
            const action = document.createElement('div');
            const todayBtn = document.createElement('div');
            const todayStatus = document.createElement('div');

            listItem.className = 'd-flex upcoming-list justify-content-between list-group-item-success align-items-center my-2 list-group-item';
            todo.className = "todo";
            action.className = "action d-flex  justify-content-between align-items-center";

            form.className = 'complete-upcoming-form';
            form.method = "POST"
            formCheck.className = "form-check";
            formCheck.innerHTML = `<input data-title="${data.title}" data-project="${data.project_id}" value="${data.id}" onclick="checkUpcoming(${data.id});" class="form-check-input" type="radio" id="${data.id}-radio">`+
                                    `<label class="form-check-label" for="${data.id}-radio">${data.title}</label>`;

            todayBtn.className = 'today-btn me-2'; 
            todayStatus.className = 'today-status text-primary text-center bg-secondary rounded-3 px-3 py-1';
            
            todayBtn.innerHTML = `<button data-id="${data.id}" class="btn btn-success text-center rounded-pill btn-sm"><i class="fas fa-pen"></i></button>`
                                +`<button onclick="deleteUpcoming('${data.id}')" data-id="${data.id}" class="delete-upcoming btn btn-success text-center rounded-pill btn-sm"><i class="fas fa-trash"></i></button>`;

            todayStatus.innerHTML = `<div class="today-status text-primary text-center bg-secondary rounded-3 px-3 py-1">
                                      `+ data.waiting == 1 ? 'waiting' : 'waiting' +`</div>`;
            form.append(formCheck);
            todo.append(form);
            action.append(todayBtn);
            action.append(todayStatus);

            listItem.appendChild(todo);
            listItem.append(action);
        
        
            upcomingList.appendChild(listItem);
        
            // console.log(listItem);

        });
        
    })
    .catch((err) => console.log(err));

}

function addUpcoming(response) {
    fetch("http://localhost:7000/upcoming", {
        method: "POST",
        body: JSON.stringify(response),
        header: {
            "Content-Type" : "application/json"
        }

    })
    .then (res => res.json())
    .then((data) => {
        console.log(upcomingTasks.push(response))
        console.log(data)
    })
    .catch((err) => console.log(err));
}


upcomingForm.addEventListener("submit", (e) => {
    e.preventDefault();
    let list = document.querySelectorAll('.upcoming-list');
    let error = "";

    if (list.length > 5) {
        alert("First Complete those task");
    }else {

        let data = {
            "title" : formInput.value,
            "project_id": formHiddenBtn.value
        }
        addUpcoming(data);

        formInput.value = "";
    }
})

function checkUpcoming(id) {
    

    if (upcomingTasks) {

        let list = document.querySelectorAll('.upcoming-list');
        let upcomingValue = document.getElementById(`${id}-radio`).value;
        let checked = document.getElementById(`${id}-radio`).dataset;
        let data = {
            "title": checked.title,
            "approved": true,
            "project_id": checked.project
        }
       addToday(data);
    
        fetch(`http://localhost:7000/upcoming_update?update=${id}`, {
            method: 'PUT', 
            headers: {'Content-Type': 'application/json'}, 
        })
        .then (res => res.json())
        .then((data) => {
            alert(data);
            window.location = '/';
        })
        .catch((err) => console.log(err));
    }
}

async function deleteUpcoming(id) {

    if( confirm("Are you sure yo want to delete this task")) {
        let data = {"id": id};

        await  fetch("http://localhost:7000/delete", {
            method: "POST",
            body: JSON.stringify(data),
            header: {
                "Content-Type" : "application/json"
            }
        })
        .then (res => res.json())
        .then((data) => {
            console.log(data);
            window.location = '/';
        })
        .catch((err) => console.log(err));

    }
}

