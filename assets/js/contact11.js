document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".php-email-form");
  const successAlert = document.getElementById("successAlert");
  const errorAlert = document.getElementById("errorAlert");

  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(form);

    fetch(form.action, {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        if (data.status === "success") {
          successAlert.textContent = data.message;
          successAlert.classList.remove("d-none");
          successAlert.classList.add("alert-success");
          errorAlert.classList.add("d-none");

          setTimeout(() => {
            successAlert.classList.add("d-none");
            form.reset(); // Reset the form after submission
          }, 5000);
        } else {
          errorAlert.textContent = data.message;
          errorAlert.classList.remove("d-none");
          errorAlert.classList.add("alert-danger");
          successAlert.classList.add("d-none");

          setTimeout(() => {
            errorAlert.classList.add("d-none");
          }, 5000);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        errorAlert.textContent =
          error.message || "Message not sent! Check console for more details.";
        errorAlert.classList.remove("d-none");
        errorAlert.classList.add("alert-danger");
        successAlert.classList.add("d-none");

        setTimeout(() => {
          errorAlert.classList.add("d-none");
        }, 5000);
      });
  });
});
