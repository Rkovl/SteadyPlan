<?php
include __DIR__.'/../partials/defaultHead.php';
include __DIR__.'/../partials/header.php';
?>
<style>
    body {
          background: linear-gradient(165deg, 
        #9fc8f7ff 50%,
        white 50%);
        min-height: 100vh;
    }
</style>
<div class="container">
    <div class="col">
        <div class="row">
            <div class="col-12 col-lg d-flex flex-column justify-content-center align-items-start">
                <h1 class="fw-bold">Steady Plan — Where tasks stay clear and progress stays steady.</h1>
                <p class="pt-3 pb-3 pe-5 me-5">Steady Plan is a collaborative project management platform designed to keep teams organized and aligned. Create projects, track tasks, assign responsibilities, and visualize progress through an intuitive Kanban workflow. Built to support clear communication, structured teamwork, and consistent project delivery.</p>
                <button class="btn btn-primary d-inline-flex align-items-center" type="button">Sign-up Today →</button>
            </div>
            <div class="col-12 col-lg-1 p-5"></div>
            <div class="col-12 col-lg">
                <img src="./images/tempShowcaseImage.png" alt="Showcase Image" class="img-fluid shadow">
            </div>
        </div>
        <div class="pt-5 pb-5 mt-5 mb-5">
        </div>
        <div class="row g-4 py-5 row-cols-1 justify-content-center"> 
            <div class="feature col-lg-4"> 
                <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3"> 
                    <svg class="m-1" width="1em" height="1em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M22 21V19C22 17.1362 20.7252 15.5701 19 15.126M15.5 3.29076C16.9659 3.88415 18 5.32131 18 7C18 8.67869 16.9659 10.1159 15.5 10.7092M17 21C17 19.1362 17 18.2044 16.6955 17.4693C16.2895 16.4892 15.5108 15.7105 14.5307 15.3045C13.7956 15 12.8638 15 11 15H8C6.13623 15 5.20435 15 4.46927 15.3045C3.48915 15.7105 2.71046 16.4892 2.30448 17.4693C2 18.2044 2 19.1362 2 21M13.5 7C13.5 9.20914 11.7091 11 9.5 11C7.29086 11 5.5 9.20914 5.5 7C5.5 4.79086 7.29086 3 9.5 3C11.7091 3 13.5 4.79086 13.5 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
 </svg> 
                </div>
                <h3 class="fs-2 text-body-emphasis">Collaborative Project Workspaces</h3> 
                <p>Steady Plan centralizes your team’s projects in a unified environment, ensuring everyone stays informed and aligned. By bringing communication, task updates, and project details together, teams reduce friction and maintain consistent momentum.</p>  
            </div> 
            <div class="feature col-lg-4"> 
                <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3"> 
                    <svg class="m-1" width="1em" height="1em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M16 4C16.93 4 17.395 4 17.7765 4.10222C18.8117 4.37962 19.6204 5.18827 19.8978 6.22354C20 6.60504 20 7.07003 20 8V17.2C20 18.8802 20 19.7202 19.673 20.362C19.3854 20.9265 18.9265 21.3854 18.362 21.673C17.7202 22 16.8802 22 15.2 22H8.8C7.11984 22 6.27976 22 5.63803 21.673C5.07354 21.3854 4.6146 20.9265 4.32698 20.362C4 19.7202 4 18.8802 4 17.2V8C4 7.07003 4 6.60504 4.10222 6.22354C4.37962 5.18827 5.18827 4.37962 6.22354 4.10222C6.60504 4 7.07003 4 8 4M9 15L11 17L15.5 12.5M9.6 6H14.4C14.9601 6 15.2401 6 15.454 5.89101C15.6422 5.79513 15.7951 5.64215 15.891 5.45399C16 5.24008 16 4.96005 16 4.4V3.6C16 3.03995 16 2.75992 15.891 2.54601C15.7951 2.35785 15.6422 2.20487 15.454 2.10899C15.2401 2 14.9601 2 14.4 2H9.6C9.03995 2 8.75992 2 8.54601 2.10899C8.35785 2.20487 8.20487 2.35785 8.10899 2.54601C8 2.75992 8 3.03995 8 3.6V4.4C8 4.96005 8 5.24008 8.10899 5.45399C8.20487 5.64215 8.35785 5.79513 8.54601 5.89101C8.75992 6 9.03995 6 9.6 6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
 </svg>
                </div> 
                <h3 class="fs-2 text-body-emphasis">Smart Task Management & Kanban Flow</h3> 
                <p>Tasks are organized through an intuitive Kanban board that makes project progress visible at a glance. This structured workflow supports faster decision-making, improves accountability, and helps teams prioritize the work that matters most.</p>  
            </div> 
            <div class="feature col-lg-4"> 
                <div class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3"> 
                    <svg class="m-1" width="1em" height="1em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
 <path d="M12 22C16 18 20 14.4183 20 10C20 5.58172 16.4183 2 12 2C7.58172 2 4 5.58172 4 10C4 14.4183 8 18 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
 </svg>
                </div> 
                <h3 class="fs-2 text-body-emphasis">Integrated Activity Tracking & Communication</h3> 
                <p>Every action, from task creation to status updates, is captured in a clear project activity feed. This transparency strengthens team coordination, minimizes miscommunication, and supports reliable, audit-ready project oversight.</p>  
            </div> 
        </div>
    </div>
</div>
<?php
include __DIR__.'/../partials/footer.php';
?>