document.addEventListener('DOMContentLoaded', function() {
  const roleForms = document.querySelectorAll('.role-form');
  const departmentForms = document.querySelectorAll('.department-form');

  roleForms.forEach((form) => {
    form.addEventListener('change', function(e) {
      e.preventDefault();
      const formData = new FormData(form);
      handleFormSubmit(form.action, form.method, formData);
    });
  });

  departmentForms.forEach((form) => {
    form.addEventListener('change', function(e) {
      e.preventDefault();
      const formData = new FormData(form);
      handleFormSubmit(form.action, form.method, formData);
    });
  });
    function handleFormSubmit(url, method, formData) {
      let xhr = new XMLHttpRequest();
      xhr.open(method, url, true);
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.success) {
              console.log('Update successful!');
            } else {
              console.log('Update failed.');
            }
          } else {
            console.error('Request failed with status:', xhr.status);
          }
        }
      };
      xhr.send(formData);
    }
  });

const Departmentforms = document.querySelectorAll('#department-form');
const Roleforms = document.querySelectorAll('#role-form');

Departmentforms.forEach((form) => {
    form.addEventListener('submit', handleFormSubmit);
});

Roleforms.forEach((form) => {
    form.addEventListener('submit', handleFormSubmit);
});

function handleFormSubmit(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: form.method,
        body: formData
    })
        .then((response) => {
            if (response.ok) {
                console.log('Update successful user!');
            } else {
                console.log('Update failed user');
            }
        })
        .catch((error) => {
            console.log('An error occurred user', error);
        });
}
