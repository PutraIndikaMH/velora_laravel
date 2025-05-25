 <style>
     .alert {
         position: absolute;
         padding: 10px;
         background-color: #f8d7da;
         color: #721c24;
         border: 1px solid #f5c6cb;
         border-radius: 5px;
         top: 100px;
         margin-bottom: 15px;
     }

     .alert ul {
         list-style-type: none;
         padding: 0;
         margin: 0;
     }

     .alert li {
         margin: 5px 0;
         /* Spacing between list items */
     }
 </style>


 @if ($errors->any())
     <div class="alert alert-danger">
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif


 <script>
     document.addEventListener("DOMContentLoaded", function() {
         const alertBox = document.querySelector('.alert'); // Select the alert box
         if (alertBox) {
             setTimeout(() => {
                 alertBox.style.transition = 'opacity 0.5s ease'; // Add fade-out transition
                 alertBox.style.opacity = '0'; // Set opacity to 0
                 setTimeout(() => {
                     alertBox.style.display = 'none'; // Hide alert after fade-out
                 }, 500); // Wait for the fade-out to complete
             }, 3000); // 3 seconds delay
         }
     });
 </script>
