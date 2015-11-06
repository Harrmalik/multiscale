<?php include_once "../layout/header.php"; ?>

   <section class="ui mobile reversed stackable grid segment pusher">
      <?php include_once "../layout/sidenav.php"; ?>

         <article id="content" class="sixteen wide mobile twelve wide tablet twelve wide computer column">
            <h2 class="ui header">GP (Generalized Particle Methods)</h2>
            
            <p>A fundamental concept of materials science is that the properties of materials flow from
            their atomic and microscopic structures[ 1]. GP&#39;s following features are developed based on this concept: </p>
            
            <div class="ui grid stackable" id="images">
               <article class="eight wide column splash">
                  <figure>
                     <img src="../img/gpfigure1.png" class="ui image" />
                     <figcaption>Fig. 1 GP concept of scale duality & structures invariance at all sales (n=1,2 ..m) with n=1 being atomic scale</figcaption>
                  </figure>
               </article>
               
               <article class="eight wide column splash">
                  <figure>
                     <img src="../img/gpfigure2.png" class="ui image" />
                     <figcaption>Fig. 2 Bottom-up & top-down scale bridging are through NLC at scale interface W<sub>nimage</sub></figcaption>
                  </figure>
               </article>
            </div>
            
            <h3 class="ui header blue">Feature 1:</h3>
            <p><b>GP is the unique concurrent multiscale method so far which keeps structures at all scales the same as 
            the atomic scale (e.g. BCC, FCC).</b></p>
            <p>Based on the GP concept of scale duality (Fig. 1) material elements can be high-scale particles in the 
            <b>&beta;</b><sub>n</sub> domain via an atom-lumping process for domains with smooth deformation gradient to save a lot of DOF. 
            Its adaptive inverse top-down decomposition processes are conducted if the domain deformation gradient becomes larger.   </p>
            
            <h3 class="ui header blue">Feature 2 :</h3>
            <p><b>GP has the same structure and the non-local constitutive behavior in both sides of the scale interface, 
            thus no behavioral incompatibility will exist.</b></p>
            <p>GP introduces two imaginary domains, W(n+1)image and W(n)image (Fig. 2) , to make seamless transition across 
            scale interface. It consists of imaginary particle which are near real particles. Imaginary particles' position is 
            determined by the statistically averaging of the real atoms in NLC. This guarantee each domain has natural 
            boundary for modeling.   </p>
            
            <h3 class="ui header blue">Feature 3 :</h3>
            <p><b>GP&#39;s calculation in all particle scale can be conducted in the corresponding <b>&alpha;</b>c atomistic domain</b></p>
            <p>by the proposed inverse mapping method based on the Cauchy-Born rule and the fact that all scales have 
            the same material crystal structure. Thus the numerical method for GP is essentially an extension of 
            MD with the same potential and can be easily incorporated into applications by modifying existing MD codes.</p>
            
            <h3 class="ui header blue">Feature 4 :</h3>
            <p><b>GP can also have linkage with FE mesh </b></p>
            <p>It appears in the remote particle domain far from the atomistic scale boundary to avoid ghost force. 
            The scale bridging does not use the DC method but using WG (or WF) domain&#39;s particle statistical averaging 
            to have bottom-up & up-down transition, etc.    </p>
            
            <h3 class="ui header blue">Feature 5 :</h3>
            <p><b>GP has wide applications: </b></p>
            <p>Nanoscale coatings, interfacial stress and fracture behavior[3]; defect nucleation and evolutions;[2,6], accuracy verification methods of multiscale methods;[5] and Crack-tip elastic and inelastic behavior.</p>
            
            <a class="ui back button right aligned blue">Back to Methods</a>
         </article>
   </section>

<?php include_once "../layout/footer.php"; ?>
