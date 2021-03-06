<?php include_once "../layout/header.php"; ?>

   <section class="ui mobile reversed stackable grid segment pusher">
      <?php include_once "../layout/sidenav.php"; ?>

         <article id="content" class="sixteen wide mobile twelve wide tablet twelve wide computer column">
            <h2 class="">Login</h2>
            <form class="ui form flat fluid">
              <div class="ui icon error message">
                  <i class="icon attention"></i>
                  <div class="content">
                      <div class="header">
                        Error
                  </div>
                </div>
              </div>
      
              <div class="fields two">
                <div class="field">
                  <label for="fName">First name</label>
                  <input name="fName" type="text" placeholder="First Name">
                </div>
      
                <div class="field">
                  <label for="lName">Last name</label>
                  <input name="lName" type="text" placeholder="Last Name">
                </div>
              </div>
      
              <div class="field">
                <label>Email</label>
                <input name="email" type="email" placeholder="name@email.com">
              </div>
      
              <div class="field">
                <label>Password</label>
                <input name="password" type="password" >
              </div>
              <div class="field">
                <label>Confirm Password</label>
                <input name="password" type="password" >
              </div>
            </form>
         </article>
   </section>

<?php include_once "../layout/footer.php"; ?>