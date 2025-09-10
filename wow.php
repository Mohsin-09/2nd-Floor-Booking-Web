<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Booking Chat Support</title>

    <!-- Google Fonts for sleek typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Basic styling and font */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Container for the chat support */
        .chat-container {
            max-width: 600px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        /* Header styling */
        .chat-container h1 {
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-weight: 600;
        }

        /* FAQ suggestions section */
        .faq-suggestions {
            padding: 15px;
            background-color: #f1f1f1;
            text-align: center;
        }

        .faq-suggestions p {
            color: #007bff;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: underline;
            margin: 5px 0;
            transition: color 0.3s;
        }

        .faq-suggestions p:hover {
            color: #0056b3;
        }

        /* Chat box area */
        .chat-box {
            max-height: 300px;
            overflow-y: auto;
            padding: 15px;
            border-top: 1px solid #ddd;
            background-color: #ffffff;
        }

        /* Individual message styling */
        .message {
            display: flex;
            align-items: center;
            margin: 10px 0;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .user-message {
            justify-content: flex-end;
            background-color: #007bff;
            color: #ffffff;
            align-self: flex-end;
            border-radius: 8px 8px 0 8px;
        }

        .bot-message {
            justify-content: flex-start;
            background-color: #f1f1f1;
            color: #333;
            align-self: flex-start;
            border-radius: 8px 8px 8px 0;
        }

        /* Input area styling */
        .input-area {
            display: flex;
            padding: 15px;
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
        }

        .input-area input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 1rem;
            outline: none;
            transition: border 0.3s;
        }

        .input-area input:focus {
            border-color: #007bff;
        }
        .typing-indicator {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.8rem;
    color: #555;
    opacity: 0.8;
    padding: 5px 12px;
    margin: 5px 0;
}

.typing-indicator span {
    display: inline-block;
    width: 8px;
    height: 8px;
    background-color: #007bff;
    border-radius: 50%;
    animation: bounce 0.6s infinite alternate;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes bounce {
    from { transform: translateY(0); }
    to { transform: translateY(-8px); }
}

        .input-area button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-left: 10px;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .input-area button:hover {
            background-color: #0056b3;
        }

        /* Scroll styling */
        .chat-box::-webkit-scrollbar {
            width: 8px;
        }
        
        .chat-box::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h1><i class="fas fa-comments"></i> Chat Support</h1>
        
        <!-- FAQ suggestions area -->
        <div id="faq-suggestions" class="faq-suggestions">
            <p>What are the rules for football?</p>
            <p>How do I make a reservation?</p>
            <p>What is the payment method?</p>
        </div>
        
        <!-- Chat box area -->
        <div id="chat-box" class="chat-box">
            <!-- Chat messages will appear here dynamically -->
        </div>
        
        <!-- Input area for user message -->
        <div class="input-area">
            <input id="user-input" type="text" placeholder="Ask a question..." autocomplete="off">
            <button onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

   <script>
    const chatBox = document.getElementById("chat-box");
const faqSuggestions = document.getElementById("faq-suggestions");
const userInput = document.getElementById("user-input");

const botResponses = {
        "hello": "Hello! How can I help you with booking cricket or football sessions in the apartment corridor?",
        "hi": "Hi there! Feel free to ask about booking, rules, pricing, or timings for cricket and football.",
        "hey": "Hey! Let me know if you need assistance with booking or have questions about our rules and timings.",
        "how are you": "I'm ready to assist! Let me know what you need help with today.",

        // Support-related terms
        "support": "For more assistance, please visit our official support page at <a href='https://m-mohsin-d3v3loper.mystrikingly.com/' target='_blank'>Support Website</a> or check out our GitHub <a href='https://github.com/mcoder1538' target='_blank'>here</a>.",
        "help": "I'm here to help! You can ask about booking details, rules, timing, or pricing. For further assistance, check our support page <a href='https://m-mohsin-d3v3loper.mystrikingly.com/' target='_blank'>here</a>.",
        "customer service": "You can reach out via our support page or let me know what specific help you need with bookings, rules, or timings.",
        "assistance": "I'd be happy to assist you! You can inquire about anything related to booking, payment, or playing rules for cricket and football.",
        "need help": "Sure, feel free to ask your questions regarding our booking, rules, or timings for cricket and football in the apartment corridor.",
        
        // Booking and reservation details
        "make a booking": "To book a session, please specify whether you’d like cricket or football, along with your preferred date and time.",
        "booking": "Booking a session is easy! Just let me know if you’d like to play cricket or football, and the time slot between 12 PM to 9 PM.",
        "reservation": "I can assist with your reservation. Specify the sport, date, and preferred time slot for me to proceed.",
        "book": "To book, let me know if you’re interested in cricket or football, and your preferred timing!",
        "how to book": "Simply mention your preferred sport (cricket or football) and time slot (12 PM - 9 PM), and I can proceed with your booking.",
        
        // Timing and availability
        "timings": "Our apartment corridor is available for cricket and football bookings daily from 12 PM to 9 PM.",
        "open hours": "You can play cricket or football between 12 PM and 9 PM daily. Let me know your preferred time for booking!",
        "hours": "Our timings are 12 PM to 9 PM every day. Which slot would you like to book?",
        "availability": "We’re open from 12 PM to 9 PM for cricket and football. Let me know your preferred slot!",
        "open time": "The corridor is available for bookings daily from 12 PM to 9 PM. Specify your preferred time slot for a booking.",
        "operating hours": "Our operational hours are 12 PM to 9 PM daily for both sports. Let me know your booking preference.",
        
        // Pricing information
        "pricing": "Each session costs 300 PKR per hour for both cricket and football. Let me know your preferred time to proceed with booking.",
        "cost": "It’s 300 PKR per hour for both cricket and football sessions.",
        "price": "The cost per hour is 300 PKR. Just let me know if you’d like cricket or football, and I’ll help with booking!",
        "rate": "We charge 300 PKR per hour for both sports. When would you like to book?",
        "how much": "Each session is 300 PKR per hour. Let me know your timing to proceed!",
        "fee": "Our fee is 300 PKR per hour for both cricket and football sessions.",
        
        // Rules for football
        "rules for football": `
        Rules for Playing Football in an Apartment Corridor:
        1. No Kicking or Hard Shots: To avoid damage to walls and floors, use soft kicks and avoid hard shots.
        2. Use a Soft Ball: Use a soft, inflatable ball designed for indoor use to minimize damage and noise.
        3. Keep the Volume Down: Avoid loud shouting or cheering to respect neighbors and maintain a peaceful environment.
        4. Clear the Area: Ensure the corridor is free of obstacles and that everyone has enough space to play safely.
        5. Respect Other Residents: Be mindful of other residents' needs and schedules. If someone needs to pass through, stop the game and allow them to go through.
        6. No Sliding or Rough Play: Sliding or rough play can damage flooring or walls. Keep movements controlled and gentle.
        7. Clean Up After Playing: After the game, clean up any mess and return the corridor to its original state.
        8. No Food or Drinks: To prevent spills and messes, no food or drinks should be brought into the playing area.
        9. Supervision for Children: If children are playing, ensure they are supervised to prevent accidents and ensure safe play.
        10. Adhere to Building Policies: Follow any specific rules or guidelines set by your building management regarding activities in common areas.
        11. No Damage to Fixtures: Any damage to lights, doorbells, or other fixtures will be considered a serious offense and may result in fines to cover repair or replacement costs.
    `,
        "football rules": "The main football rules include using a soft ball, no kicking hard shots, keeping volume low, and respecting residents. Need more details?",
        "soccer rules": "Indoor football rules involve soft balls, avoiding hard kicks, and keeping volume low. Check with me for more specific guidelines!",
        
        // Rules for cricket
        "rules for cricket": `
        Rules for Playing Cricket in an Apartment Corridor:
        1. No Fast Shots: To avoid damage to walls and floors, do not play fast or hard shots. Use gentle swings and soft balls.
        2. Stop While Someone is Passing: If someone needs to pass through the corridor, stop the game and let them through. Resume play once the area is clear.
        3. Use a Soft Ball: Use a soft, lightweight cricket ball designed for indoor use to reduce noise and prevent damage.
        4. Keep the Volume Down: Avoid loud shouting or cheering to maintain a peaceful environment for other residents.
        5. Clear the Area: Ensure the corridor is free of obstacles and that everyone has enough space to play safely.
        6. No Sliding or Rough Play: Avoid sliding or rough play to prevent damage to flooring or walls.
        7. Clean Up After Playing: Clean up any mess and restore the corridor to its original state after the game.
        8. No Food or Drinks: Do not bring food or drinks into the playing area to avoid spills and messes.
        9. Supervision for Children: Ensure that children are supervised during play to prevent accidents and ensure safe play.
        10. Adhere to Building Policies: Follow any specific rules or guidelines set by your building management regarding activities in common areas.
        11. No Damage to Fixtures: Any damage to lights, doorbells, or other fixtures will be considered a serious offense and may result in fines to cover repair or replacement costs.
    `,
     "what are the rules for football?": `
        Rules for Playing Football in an Apartment Corridor:
        1. No Kicking or Hard Shots: To avoid damage to walls and floors, use soft kicks and avoid hard shots.
        2. Use a Soft Ball: Use a soft, inflatable ball designed for indoor use to minimize damage and noise.
        3. Keep the Volume Down: Avoid loud shouting or cheering to respect neighbors and maintain a peaceful environment.
        4. Clear the Area: Ensure the corridor is free of obstacles and that everyone has enough space to play safely.
        5. Respect Other Residents: Be mindful of other residents' needs and schedules. If someone needs to pass through, stop the game and allow them to go through.
        6. No Sliding or Rough Play: Sliding or rough play can damage flooring or walls. Keep movements controlled and gentle.
        7. Clean Up After Playing: After the game, clean up any mess and return the corridor to its original state.
        8. No Food or Drinks: To prevent spills and messes, no food or drinks should be brought into the playing area.
        9. Supervision for Children: If children are playing, ensure they are supervised to prevent accidents and ensure safe play.
        10. Adhere to Building Policies: Follow any specific rules or guidelines set by your building management regarding activities in common areas.
        11. No Damage to Fixtures: Any damage to lights, doorbells, or other fixtures will be considered a serious offense and may result in fines to cover repair or replacement costs.
    `,
    "how do I make a reservation?": `
        To make a reservation:
        1. Visit the booking section of our website.
        2. Fill in the required information, including your preferred date and time.
        3. Confirm your booking by submitting the form.
    `,
    "what is the payment method?": `
        Payment Methods:
        - We currently accept cash payments at the venue.
        - Please ensure to bring the required amount for your booking.
    `,
        "cricket rules": "The indoor cricket rules include soft shots only, using a soft ball, and respecting neighbors. Would you like further details?",
        "rules cricket": "Our rules require soft balls, gentle swings, and no loud noise. If you'd like the full list, just ask!",
        
        // FAQs on facilities, contact, and cancellations
        "facilities": "Since it’s a shared corridor, facilities are limited. Please be mindful of rules for safe play.",
        "contact information": "For further assistance, check our support page or reach out directly through our official site.",
        "cancellation": "If you need to cancel a booking, please let us know at least 2 hours in advance to avoid charges.",
        "how to cancel": "To cancel, simply inform us via this chat or contact our support at least 2 hours before your session starts.",
        
        // Default response for unmatched queries
        "default": "I'm here to help! Please ask a specific question, like 'booking,' 'football rules,' or 'pricing.'"
    };


// Add default FAQs
document.querySelectorAll("#faq-suggestions p").forEach(suggestion => {
    suggestion.addEventListener("click", () => {
        userInput.value = suggestion.innerText;
        faqSuggestions.style.display = 'none';
    });
});
// Function to send user message
function sendMessage() {
    const message = userInput.value.trim();
    
    if (message) {
        // Display the user's message in the chat box
        addMessage(message, "user-message");
        userInput.value = ""; // Clear the input field

        // Hide FAQ suggestions after the user enters a message
        faqSuggestions.style.display = 'none';

        // Generate bot response and trigger the typing effect
        const responseText = botResponses[message.toLowerCase()] || botResponses["default"];
        
        // Typing effect with delay
        addTypingEffect(responseText);
    }
}

// Typing effect function to display message letter by letter
function addTypingEffect(text) {
    const botMessageElement = document.createElement("div");
    botMessageElement.className = "message bot-message";
    chatBox.appendChild(botMessageElement); // Add empty message container for typing effect
    
    let index = 0;

    // Type out each letter with a set delay to mimic typing
    const typingInterval = setInterval(() => {
        if (index < text.length) {
            botMessageElement.innerHTML += text.charAt(index); // Add one character at a time
            index++;
            chatBox.scrollTop = chatBox.scrollHeight; // Keep scrolling to the bottom
        } else {
            clearInterval(typingInterval); // Stop typing when message is fully displayed
        }
    }, 30); // Speed of typing effect (adjust as desired)
}

// Function to add message to chat box
function addMessage(text, className) {
    const messageElement = document.createElement("div");
    messageElement.className = `message ${className}`;
    messageElement.innerHTML = text;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom
}

// Display FAQ suggestions on page load
window.onload = () => {
    faqSuggestions.style.display = 'block';
};

</script>

</body>
</html>
