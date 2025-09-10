 // Save the original title
 const originalTitle = document.title;
 const newTitle = 'Book More';

 // Function to change the title
 function handleVisibilityChange() {
     if (document.hidden) {
         // If the document is hidden (user switches tab)
         document.title = newTitle;
     } else {
         // If the document is visible again
         document.title = originalTitle;
     }
 }

 // Add event listener for visibility change
 document.addEventListener('visibilitychange', handleVisibilityChange);
