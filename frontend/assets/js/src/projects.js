const projects = document.querySelector(".project-list");
const projectCount = document.querySelector(".project-count");
const proHeader  =  document.querySelector("#pro");
const projectBox = document.querySelector(".project-box");
// FORM ELEMENTS
const projectForm = document.getElementById("project-form");
const projectTitle = document.querySelector("#project-title");
const projectDesc = document.querySelector("#project-description");
const startDate = document.querySelector("#start-date");
const endDate = document.querySelector("#end-date");
const displayColor = document.querySelector("#display-color");
const projectID = document.querySelectorAll('.project-box');
const projectContainer = document.getElementById('#main');

const filterInput = document.querySelector("#filter");

let allProjects;

let projectElementByIds = {};

filter.addEventListener("input", filterList);

projectForm.addEventListener("submit", (e) => {
    e.preventDefault();
    
    let data = {
        "title" : projectTitle.value,
        "description": projectDesc.value,
        "display_color": displayColor.value,
        "start_date" : startDate.value,
        "end_date" :  endDate.value 
    };
    addProject(data);
    
})


function addProject(res) {
    fetch("http://localhost:7000/projects", {
        method: "POST",
        body: JSON.stringify(res),
        header: {
            "Content-Type" : "application/json"
        }

    })
    .then (res => res.json())
    .then((data) => {
        console.log(data);
    })
    .catch((err) => console.log(err));
}

function fetchProjects() {
    fetch("http://localhost:7000/projects")
    .then (res => res.json())
    .then((datas) => {

        allProjects = datas;
        projectCount.textContent = '('+datas.length+')';

        datas.forEach((data) => {
            const col_4 = document.createElement('div');
            col_4.className = "col-md-4 col-sm-6 my-2 project-box";

            col_4.id = `project-${data.project_id}`;
            col_4.innerHTML = `<a onclick='load(this)' data-id="${data.project_id}" class="nav_link" href="#/${data.project_id}"><div style="background:${data.display_color};" class="py-5 px-3 text-center rounded-3">PT</div>
                                <h5 style="font-size:0.77em !important;" class="text-center my-2">${data.title}</h5></a>`

            projects.appendChild(col_4);
        });
       


    })
    .catch((err) => console.error(err));
}

async function fetchProjectById(id) {
  await  fetch(`http://localhost:7000/project_single?id=${id}`)
    .then (res => res.json())
    .then((datas) => {
        const projectTitle = document.querySelector('.project-title');
        const desc = document.querySelector('.project-description p');
        const formBtn = document.getElementById("hidden-btn");

        projectTitle.textContent = datas[0].title;
        desc.textContent = datas[0].description;
        formBtn.value = datas[0].project_id;
        fetchtUpcoming(datas[0].project_id);
        fetchDaily(datas[0].project_id);
    })
    .catch((err) => console.log(err));

}

function load(e) {
    // let elm = e.dataset.id;

    const allLinks = document.querySelectorAll('.nav_link');
    // console.log(e.hash);

    let intoArr = [...allLinks];

    const regex = new RegExp(e.hash, 'gi');
    intoArr.find((arr) => arr.hash === e.hash )
   

    // intoArr.forEach((arr) => {
    //     let und = document.querySelectorAll('li');
    //     console.log(und);
       
    //     if (arr.hash.match(regex) != null) {
    //         // fetchProjectById(arr.dataset.id)
    //         console.log(arr.hash)
    //     }else {
    //         return;
    //     }

    // })
    
}


document.addEventListener('DOMContentLoaded', (e) => {
    fetchProjects();
    fetchProjectById(5)

});

function filterList() {
    if (allProjects) {
        console.log(allProjects);
        const regExp = new RegExp(filterInput.value, 'gi');

       allProjects.forEach((project) => {
        if (project.title.match(regExp)) {
            document.querySelector(`#project-${project.project_id}`).style.display = 'block';
        }else {
            document.querySelector(`#project-${project.project_id}`).style.display = 'none';
        }

       });
    }
}


// window.addEventListener('DOMContentLoaded',jds);





