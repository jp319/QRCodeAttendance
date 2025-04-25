// Show the issue input form when "Can't log in?" is clicked
function showIssueForm() {
    document.getElementById("issue-form").style.display = "block";
}

// Hide the issue input form
function hideIssueForm() {
    document.getElementById("issue-form").style.display = "none";
}

// Submit the issue form and open the email client
function submitIssue() {
    var issueDetails = document.getElementById("issueDetails").value;
    if (issueDetails.trim() !== "") {
        // Open email client with the issue details
        var email = "ddtiongson00006@usep.edu.ph"; // Replace with your support email
        var subject = "Login Issue";
        var body = encodeURIComponent("Issue Description: " + issueDetails);

        // Construct the mailto link
        var mailtoLink = "mailto:" + email + "?subject=" + subject + "&body=" + body;
        window.location.href = mailtoLink;

        // Hide the form after submission
        hideIssueForm();
    } else {
        alert("Please specify the issue before submitting.");
    }
}

