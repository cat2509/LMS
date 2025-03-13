window.onload = function () {
    google.accounts.id.initialize({
        client_id: "YOUR_GOOGLE_CLIENT_ID", // Replace with actual client ID
        callback: handleCredentialResponse
    });

    google.accounts.id.renderButton(
        document.getElementById("google-signin"),
        { theme: "outline", size: "large" }
    );

    google.accounts.id.prompt(); // Show One Tap Login
};

// Handle login response
function handleCredentialResponse(response) {
    const email = jwt_decode(response.credential).email;
    if (email.endsWith("@somaiya.edu")) {
        console.log("Allowed User:", email);
        alert("Login successful! Welcome, " + email);
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
