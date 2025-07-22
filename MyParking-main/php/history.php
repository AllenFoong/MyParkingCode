<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Parking History - Smart Parking</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <a href="dashboard.php" class="back-btn">← Back</a>
    <h2>Parking History</h2>
    <div id="history-list" class="history-list"></div>
  </div>

  <script>
    const historyList = JSON.parse(localStorage.getItem("parkingHistory")) || [];

    function renderHistory() {
      const container = document.getElementById("history-list");
      container.innerHTML = "";

      if (historyList.length === 0) {
        container.innerHTML = "<p>No booking history found.</p>";
        return;
      }

      historyList.forEach((item, index) => {
        const card = document.createElement("div");
        card.className = "card";

        const info = document.createElement("div");
        info.innerHTML = `
          <strong>Date:</strong> ${item.date}<br>
          <strong>Vehicle:</strong> ${item.vehicle}<br>
          <strong>Duration:</strong> ${item.duration}<br>
          <strong>Fee:</strong> ${item.fee}
        `;

        const cancelBtn = document.createElement("button");
        cancelBtn.textContent = "Cancel";
        cancelBtn.style.backgroundColor = "#dc3545";
        cancelBtn.onclick = () => {
          if (confirm("Are you sure you want to cancel this booking?")) {
            historyList.splice(index, 1);
            localStorage.setItem("parkingHistory", JSON.stringify(historyList));
            renderHistory();
          }
        };

        const actionDiv = document.createElement("div");
        actionDiv.className = "card-actions";
        actionDiv.appendChild(cancelBtn);

        card.appendChild(info);
        card.appendChild(actionDiv);

        container.appendChild(card);
      });
    }

    renderHistory();
  </script>
</body>
</html>
