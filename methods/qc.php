<?php include_once "../layout/header.php"; ?>

   <section class="ui mobile reversed stackable grid segment pusher">
      <?php include_once "../layout/sidenav.php"; ?>

         <article id="content" class="sixteen wide mobile twelve wide tablet twelve wide computer column">
            <h2 class="ui header">QC (Quasi-Continuum)</h2>
            
            <h3 class="ui header blue">Introduction</h3>
            <p>In QC, full atomistic detail is retained in regions of interest where it is required while 
            continuum assumption is introduced to reduce the computational demand elsewhere [19, 20]. In 
            the continuum region, a fraction of atoms are selected as representative atoms (repatoms) whose 
            force/energy are calculated to decide the nodal positions while the remaining atoms are 
            interpolated from the nodes following the Cauchy-Born rule [21]. A number of variations of 
            the QC approach, e.g., those of local/non-local, energy/force based, and different summation 
            rules, have been developed [22].  Different adaptive mesh refinement algorithms can be used 
            to refine elements to full atomistic resolution as well as to coarsen a collection of atoms 
            into elements [23].  In QC, FE mesh is independent of the underlying lattice, except that the
            repatoms have to coincide with actual atoms. Therefore, the QC method takes advantage of the 
            FE approach such as in meshing and adaptive mesh refinement procedures. In most cases, linear 
            triangular/tetrahedral elements are employed through a Delaunay triangulation although 
            higher-order elements of other shape are sometimes used. Quasistatic, zero temperature 
            dynamic, finite temperature equilibrium/non-equilibrium dynamic versions of the QC method 
            have been proposed and employed to simulate the thermomechanical response of a wide range of 
            crystalline materials [24]. It is usually considered one of the most popular and extensively 
            evaluated multiscale modeling methods [25].</p>
            
            <h3 class="ui header blue">Features</h3>
            <ol>
              <li>Only a small fraction of repatoms are solved in the continuum region, reducing most of the degrees of 
              freedom in the system;</li>
              <li>Adaptive mesh refinement procedures are employed to maintain full atomistic resolution around defects
              , e.g., void, crack, surface, grain boundary, dislocation;</li>
              <li>A variety of alternative versions of the QC method exist, which have undergone rather extensive 
              and careful investigations by a number of research groups globally and are supported by a website with open source code (www.qcmethod.org); </li>
              <li>Support a wide range of lattice structures (FCC, BCC, diamond cubic, nanotube, graphene, etc) and 
              interatomic potentials (Lennard-Johns, Embedded-Atom Method, Stillinger-Weber, etc.).</li>
              <li>The static version of the QC method is based on lattice statics while the dynamic versions are 
              based on free energy minimization [20], potential of mean force method [24], Langevin dynamics [26],
              maximum-entropy variational approach [27], etc.</li>
            </ol>
            
            <h3 class="ui header blue">Applications</h3>
            <ol>
              <li>
                Crack growth in brittle fracture
              </li>
              <li>
                Crack-grain boundary interaction and dislocation&#45;grain boundary interaction
              </li>
              <li>
                Dislocation&#45;dislocation interaction and junction formation
              </li>
              <li>
                Dislocation&#45;obstacles interaction
              </li>
              <li>
                Nanoindentation and homogeneous dislocation nucleation
              </li>
              <li>
                Finite deformation of membrane
              </li>
              <li>
                Polarization switching in piezoelectric materials
              </li>
              <li>
                Deformation twinning
              </li>
              <li>
                Misfit/fracture at bi-material interface
              </li>
              <li>
                Nanovoid deformation/collapse
              </li>
              <li>
                Nanometric cutting of a crystal
              </li>
              <li>
                Plastic deformation of a nanopillar
              </li>
              <li>
                Dislocation nucleation from grain boundary
              </li>
            </ol>
            
            <a class="ui back button right aligned blue">Back to Methods</a>
         </article>
   </section>

<?php include_once "../layout/footer.php"; ?>
