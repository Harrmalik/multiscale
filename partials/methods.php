<?php include_once "../layout/header.php"; ?>

   <section class="ui mobile reversed stackable grid segment pusher container">
      <?php include_once "../layout/sidenav.php"; ?>

         <article id="content" class="sixteen wide mobile twelve wide tablet twelve wide computer column">
            <h2 class="ui header">Concurrent Multiscale Methods of Modeling and Simulation</h2>
            <div class="ui list">
              <div class="item"><span class="ui header blue">QC</span> Short for quasi-continuum method. It uses Cauchy-Born rule for the
                 first time to calculate the strain energy density W in the FE region, thus both atomistic and 
                 continuum region can be treated with atomic potential function.  It was proposed in 1996 with a 
                 lot of applications.  
              </div>
              <div class="item"><span class="ui header blue">CADD</span> Short for couples atomistic analysis with the discrete dislocation
              (DD) method. Based on the need to create the force boundary by a superposition process, the method is force-based multiscale 
              analysis. The focus on dislocation of the CADD method necessitates the use of linear elasticity.   
              </div>
              <div class="item"><span class="ui header blue">CAC</span>  which is proposed to improve
              the simulation of material defects. Within each element, lattice defects are not allowed. However, between elements, neither 
              displacement continuity nor strain compatibility is requiblue. In mathematical community, the same CAC terminology is used which
              investigates convergence theory of domain truncation, etc.
              </div>
              <div class="item"><span class="ui header blue">ESCM</span> Short for embedded statistical coupling method which uses statistically
              averaging over selected time interval and volume in atomistic subdomains at the MD/FE interface to determine nodal displacement
              for the continuum FE domain.
              </div>
              <div class="item"><span class="ui header blue">GP</span> Short for generalized particle methods. It consists of different scales
              of particle domains to keep material structure and numerical algorithm the same as atomic scale. Both bottom-up and top-down scale
              transition are through atoms/particles in NLC. FE mesh only appears for large-size models in the far remote field from atomistic 
              scale to avoid ghost force. (NLC:  Neighbor Link Cells)  
              </div>
              <div class="item"><span class="ui header blue">QC Code</span> can be downloaded here with http://qcmethod.org/qc/download; More 
              information can be obtained from the above website.   
              </div>
              <div class="item"><span class="ui header blue">PMAP Code of the GP</span> Short for The Particle-Based Multiscale Analysis Program. In this website,
              the user manual and its tutorial will be offered for model development and simulation. For some potential users who hope collaboration
              to use PMAP and other codes that IIMMM has we will offer more materials including detail examples for applications to help the users.   
              </div>
            </div>
         </article>
   </section>

<?php include_once "../layout/footer.php"; ?>
