// Initialize Google Sign-In
google.accounts.id.initialize({
    client_id: "YOUR_GOOGLE_CLIENT_ID",
    callback: handleCredentialResponse
});

// Render Google Sign-In Button
google.accounts.id.renderButton(
    document.getElementById("google-signin"),
    { theme: "outline", size: "large" }
);

// Handle Google Login Response
function handleCredentialResponse(response) {
    const email = jwt_decode(response.credential).email;
    if (email.endsWith("@somaiya.edu")) {
        console.log("Allowed User:", email);
        // Proceed with login or registration
    } else {
        alert("Only Somaiya students can sign up!");
    }
}

// Toggle password visibility
document.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".toggle-password").addEventListener("click", () => {
        const passwordInput = document.getElementById("password");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    });
});
