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
  <title>Payment Method</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="container">
    <a href="dashboard.php" class="back-btn">← Back</a>
    <h2>Payment Method</h2>
    <div id="card-list"></div>

    <div class="new-card">
      <h3>Add New Card</h3>
      <input type="text" id="cardNumber" placeholder="Card Number" maxlength="16" oninput="this.value=this.value.replace(/\D/g,'')" />
      <input type="text" id="expiry" placeholder="Expiry (MM/YY)" maxlength="5" oninput="expiryFormat(this)" />
      <input type="text" id="cvv" placeholder="CVV" maxlength="3" oninput="this.value=this.value.replace(/\D/g,'')" />
      <input type="text" id="cardName" placeholder="Cardholder Name" />
      <button onclick="addCard()">Add Card</button>
    </div>
  </div>

  <script>
    let cards = JSON.parse(localStorage.getItem("cards")) || [];
    let defaultCard = localStorage.getItem("defaultCard") || "";

    function expiryFormat(input) {
      input.value = input.value.replace(/\D/g, '');
      if (input.value.length > 2) {
        input.value = input.value.slice(0,2) + '/' + input.value.slice(2,4);
      }
    }

    function renderCards() {
      const container = document.getElementById("card-list");
      container.innerHTML = "";

      cards.forEach((card, index) => {
        const row = document.createElement("div");
        row.className = "card";

        const label = document.createElement("span");
        label.innerHTML = `•••• ${card.number.slice(-4)}`;

        const button = document.createElement("button");
        button.textContent = "Update";
        button.onclick = () => {
          updateCard(index);
        };

        const radio = document.createElement("input");
        radio.type = "radio";
        radio.name = "default";
        radio.className = "radio";
        radio.checked = card.number === defaultCard;
        radio.onclick = () => {
          defaultCard = card.number;
          saveCards();
        };

        const rightDiv = document.createElement("div");
        rightDiv.className = "card-actions";
        rightDiv.appendChild(button);
        rightDiv.appendChild(radio);

        row.appendChild(label);
        row.appendChild(rightDiv);
        container.appendChild(row);
      });
    }

    function addCard() {
      const number = document.getElementById("cardNumber").value;
      const expiry = document.getElementById("expiry").value;
      const cvv = document.getElementById("cvv").value;
      const name = document.getElementById("cardName").value;
      const brand = number.startsWith("4") ? "Visa" : "Mastercard";

      if (number.length === 16 && expiry.length === 5 && cvv.length === 3 && name.trim()) {
        cards.push({ number, expiry, cvv, name, brand });
        saveCards();
      } else {
        alert("Invalid details! Please ensure all fields are correctly filled.");
      }
    }

    function updateCard(index) {
      const card = cards[index];
      const newNum = prompt("Enter new 16-digit card number:", card.number);
      const newExpiry = prompt("Enter new expiry (MM/YY):", card.expiry);
      const newCVV = prompt("Enter new CVV:", card.cvv);
      const newName = prompt("Enter new Cardholder Name:", card.name);

      if (newNum && newExpiry && newCVV && newName &&
          /^\d{16}$/.test(newNum) && /^\d{2}\/\d{2}$/.test(newExpiry) && /^\d{3}$/.test(newCVV)) {
        cards[index] = {
          number: newNum,
          expiry: newExpiry,
          cvv: newCVV,
          name: newName,
          brand: newNum.startsWith("4") ? "Visa" : "Mastercard"
        };
        saveCards();
      } else {
        alert("Invalid details provided!");
      }
    }

    function saveCards() {
      localStorage.setItem("cards", JSON.stringify(cards));
      localStorage.setItem("defaultCard", defaultCard);
      renderCards();
    }

    renderCards();
  </script>
</body>
</html>
