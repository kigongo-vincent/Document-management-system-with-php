const nodemailer = require("nodemailer");

// Create a transporter using the default SMTP transport
const transporter = nodemailer.createTransport({
  service: "Gmail", // e.g., "Gmail", "Outlook"
  auth: {
    user: "kigongovincent81@gmail.com",
    pass: "Vincent_1966",
  },
});

// Email content
const mailOptions = {
  from: "kigongovincent81@gmail.com",
  to: "kigongovincent625@gmail.com",
  subject: "Hello from Nodemailer",
  text: "This is a test email sent from Nodemailer.",
};

// Send the email
transporter.sendMail(mailOptions, (error, info) => {
  if (error) {
    console.error("Error sending email:", error);
  } else {
    console.log("Email sent:", info.response);
  }
});
