const courseList = document.querySelector("#course-list");
const tutorialList = document.querySelector("#tutorial-list");
const mentorshipList = document.querySelector("#mentorship-list");

fetch("data.php")
  .then(response => response.json())
  .then(data =>) {
    data.courses.forEach(course =>) {
      const li = document.createElement("li");
      li.textContent = course;