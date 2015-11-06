<?php include_once "../layout/header.php"; ?>

   <section class="ui mobile reversed stackable grid segment pusher">
      <?php include_once "../layout/sidenav.php"; ?>

         <article id="content" class="sixteen wide mobile twelve wide tablet twelve wide computer column">
            <h2 class="ui header">CAC</h2>
            
            <h3 class="ui header blue">Introduction</h3>
            <p>In most partitioned-domain methods, lattice defects in the continuum are either implemented via 
            constitutive relations, lattice elasticity with dislocation field interactions, or are not permitted 
            at all [7, 13]. In such approaches, the transit of dislocations across the atomistic/continuum interface
            appeals to approximate heuristics intended to minimize the effects of the interface due to the change 
            from atomistic to continuum degrees of freedom. This motivated development of a new multiscale method
            called the concurrent atomistic-continuum (CAC) method that admits displacement discontinuous between 
            elements in the continuum. Within each element, lattice defects are not allowed and the displacement
            field has C1 continuity; between elements, however, neither displacement continuity nor strain
            compatibility is required.</p>
            
            <p>The theoretical foundation of the CAC method is a unified atomistic-continuum formulation, in
            which a crystalline material is viewed as a continuous collection of lattice points, while embedded 
            within each point is a unit cell with a group of discrete atoms [2, 8]. The same balance 
            equations and interatomic potential (which serves as the only constitutive relation) are
            employed in both fully resolved atomistic and coarse-grained continuum domains.</p>
            
            <p>Note that while other multiscale approaches may also carry the name CAC, our use of this 
            term only pertains to the particular method involved in the selected publications in the References.</p>
            
            <h3 class="ui header blue">Features</h3>
            <ol>
              <li>In the continuum domain, use rhombohedral or hybrid elements whose surfaces correspond to slip planes in lattices to accommodate 
              intrinsic stacking faults and planar dislocations whose core structure/energy, Burgers vector, and long range stress fields are well 
              preserved;</li>
              <li>Dislocations smoothly pass through the atomistic/coarse-grained domain interface which has no ghost force, without any ad hoc 
              treatments;</li>
              <li>Support a wide range of lattice structures (FCC, BCC, diamond cubic, simple cubic, etc) and interatomic potentials (Lennard-Johns, 
              Embedded-Atom Method, Stillinger-Weber, Born-Mayer, Coulomb, etc.) for monoatomic and polyatomic crystalline materials;</li>
              <li>There are quasistatic, quenched dynamic, and dynamic versions of the CAC method, with adaptive mesh refinement function to retain 
              full atomistic resolution wherever necessary;</li>
              <li>The CAC simulation runs in parallel using Message Passing Interface (MPI) and spatial-decomposition algorithm.</li>
            </ol>
            
            <h3 class="ui header blue">Applications</h3>
            <ol>
              <li>
                Dislocation nucleation from notched specimen [9]
              </li>
              <li>
                Nanoindentation [10]
              </li>
              <li>
                Dislocation-void interactions [11]
              </li>
              <li>
                 Nucleation and growth of dislocation loops [12]
              </li>
              <li>
                Brittle fracture with branching of cracks [13]
              </li>
              <li>
                Impact of a rigid ball against a plate [14]
              </li>
              <li>
                Phonon drag on dislocations [15]
              </li>
              <li>
                Phonon transport between atomistic and coarse-grained domains [16]
              </li>
              <li>
                Crack-grain boundary interaction [17]
              </li>
              <li>
                Crack and dislocation nucleation from grain boundary in a polycrystal [18]
              </li>
              <li>
                Dislocation nucleation from crack tip in ductile fracture
              </li>
              <li>
                Dislocation-grain boundary interactions
              </li>
            </ol>
            
            <a class="ui back button right aligned blue">Back to Methods</a>
         </article>
   </section>

<?php include_once "../layout/footer.php"; ?>
