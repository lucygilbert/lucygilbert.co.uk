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

function changePage(selectedPage) {
  Object.keys(Pages).forEach(function (key) {
    var page = document.getElementById(Pages[key]);
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
