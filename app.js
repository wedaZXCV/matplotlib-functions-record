const newFunction = document.querySelector('#add-function');
const newActivity = document.querySelector('#add-activity');
const goFunction = document.querySelector('#go-to-function-list')
const goActivity = document.querySelector('#go-to-activity-list')

newFunction.addEventListener('click', goToNewFunctionPage);
newActivity.addEventListener('click', goToNewActivityPage);
goFunction.addEventListener('click', goToFunctionListPage);
goActivity.addEventListener('click', goToActivityListPage);

//Event Handler
function goToNewFunctionPage(e) {
  //window.location.replace("functions-page.html")
  window.location = "new-function.html";
  e.preventDefault();
}

function goToNewActivityPage(e) {
  window.location = "new-activities.html";
  e.preventDefault();
}

function goToFunctionListPage(e) {
  window.location = "functions-page.html";
  e.preventDefault();
}

function goToActivityListPage(e) {
  window.location = "activities-page.html";
  e.preventDefault();
}