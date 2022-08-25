const todayList = document.querySelector(".today-list");


async function fetchDaily(id) {
   await fetch(`http://localhost:7000/daily_single?id=${id}`)
    .then (res => res.json())
    .then((datas) => {

        if (datas.length == "" ) {
            const notFoundTask = document.createElement('li');
            todayList.className = "p-4 alert alert-danger my-2";
            notFoundTask.className = 'd-flex justify-content-between align-items-center';
            notFoundTask.textContent = "No Daily tasks found, please add today's task";
            todayList.appendChild(notFoundTask);

        }
        datas.forEach((data) => {
            const listItem = document.createElement('li');
            const todo = document.createElement('div');
            const form = document.createElement('form');
            const formCheck = document.createElement('div');
            const action = document.createElement('div');
            const todayBtn = document.createElement('div');
            const todayStatus = document.createElement('div');

            form.method = "POST";

            listItem.className = 'd-flex justify-content-between daily-list list-group-item-success align-items-center my-3 list-group-item';
            todo.className = "todo";
            action.className = "action d-flex  justify-content-between align-items-center";

            form.className = 'complete-form';
            formCheck.className = "form-check";
            formCheck.innerHTML = `<input onclick="completedTask('${data.id}')" class="form-check-input" type="radio" name="flexRadioDefault" id="${data.id}-radio">`+
                                    `<label class="form-check-label" for="${data.id}-radio">${data.title}</label>`;

            todayBtn.className = 'today-btn me-2'; 
            todayStatus.className = 'today-status text-primary text-center bg-secondary rounded-3 px-3 py-1';
            
            todayBtn.innerHTML = `<button data-id="${data.id}" class="btn btn-success text-center rounded-pill btn-sm"><i class="fas fa-pen"></i></button>`
                                +`<button onclick="deleteDaily('${data.id}')" data-id="${data.id}" class="btn btn-success text-center rounded-pill btn-sm"><i class="fas fa-trash"></i></button>`;

            todayStatus.innerHTML = `<div class="today-status text-primary text-center bg-secondary rounded-3 px-3 py-1">
                                      `+ data.approved == 0 ? 'approved' : 'in progress' +`</div>`;
            form.append(formCheck);
            todo.append(form);
            action.append(todayBtn);
            action.append(todayStatus);

            listItem.appendChild(todo);
            listItem.append(action);
        
        
            todayList.appendChild(listItem);
        
            // console.log(listItem);
        });
    })
    .catch((err) => console.log(err));
}

function addToday(res) {

    let dailyList = document.querySelectorAll('.daily-list');
    if (dailyList.length == 5) {
       return alert("First complete these tasks");
    }else {
        fetch("http://localhost:7000/dailytasks", {
        method: "POST",
        body: JSON.stringify(res),
        header: {
            "Content-Type" : "application/json"
        }

    })
    .then (res => res.json())
    .then((data) => {
        console.log(data);
        // window.location = '/';
    })
    .catch((err) => console.log(err));
    }
    
}

async function deleteDaily(id) {
    const confirmMessage = "Are you sure yo want to delete this dsily task";
    if (confirm(confirmMessage)) {
        let data = {"id": id};
        await  fetch("http://localhost:7000/delete_daily", {
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

async function completedTask(id){
    await fetch(`http://localhost:7000/complete_task`, {
        mode: 'no-cors',
        method: 'POST', 
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({"id": id})
    })
    .then (res => res.json())
    .then((data) => {
        alert(data);
        // window.location = '/';
    })
    .catch((err) => console.log(err));

}

