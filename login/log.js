document.addEventListener("DOMContentLoaded", () => {
  const signInDiv = document.getElementById("signIn");
  const signUpDiv = document.getElementById("signup");
  const signUpBtn = document.getElementById("signUpButton");
  const signInBtn = document.getElementById("signInButton");

  if (signUpBtn) {
    signUpBtn.addEventListener("click", () => {
      signInDiv.style.display = "none";
      signUpDiv.style.display = "block";
    });
  }

  if (signInBtn) {
    signInBtn.addEventListener("click", () => {
      signUpDiv.style.display = "none";
      signInDiv.style.display = "block";
    });
  }
});
