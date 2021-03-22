// Version 1.2

var Pages = {
  ABOUT: 'about',
  SKILLS: 'skills',
  EMPLOYMENT: 'employment',
  CONTACT: 'contact',
};
var PageLinks = {
  ABOUT: 'aboutLink',
  SKILLS: 'skillsLink',
  EMPLOYMENT: 'employmentLink',
  CONTACT: 'contactLink',
};

function initialLoad() {
  var pageQuery = window.location.search.match('page=([a-zA-Z]*)&*');
  var page = pageQuery && pageQuery[1];
  return changePage(page || Pages.ABOUT);
}

function changePage(selectedPage) {
  var navCheck = document.getElementById('nav-check');
  navCheck.checked = false;
  Object.keys(Pages).forEach(function (key) {
    var page = document.getElementById(Pages[key]);
    if (page == null) return;
    var pageLink = document.getElementById(PageLinks[key]);
    var displayType;

    if (Pages[key] === selectedPage) {
      pageLink.classList.add('nav-link--selected');
      displayType = 'block';
    } else {
      pageLink.classList.remove('nav-link--selected');
      displayType = 'none';
    }

    page.style.display = displayType;
  });
}
