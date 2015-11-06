<?php include_once "../layout/header.php"; ?>

   <section class="ui mobile reversed stackable grid segment pusher">
      <?php include_once "../layout/sidenav.php"; ?>

         <article id="content" class="sixteen wide mobile twelve wide tablet twelve wide computer column">
            <h2 class="ui header">Frequent Ask Questions</h2>
            <h3 class="ui header">General Questions</h3>
            
            <h3>1.   Why do we need multiscale material modeling?</h3>
            <p>A:  It is by now widely recognized that materials are inherently of multiscale, hierarchical character. Material behavior should not be considered only at phenomenological levels, as historically taught. Rather, important properties and material responses can arise at a myriad of length scales and the phenomenological behavior of the continuum follows from their atomic and microscopic structures. The significance of multiscale analysis naturally follows this understanding and it brings the hope that new concepts and methods can be developed based on 
low scale structures, behaviors, and physics. For concurrent modeling this is absolutely necessary because one must use atomistic scale to simulate the crystal defects (e.g. vacancy, dislocations).  On the other hand, for most part of the model it must use continuum to save DOF.  
</p>
            <h3>2.	Does using the new technique of connecting FE nodes to remote particles allow atomistically-based multiscale methods to potentially be used in structural analysis?</h3>
            <p>A: Yes. Two limitations have made concurrent multiscale analysis difficult to be used in large model design including component structural analysis: One is a lack of methods for simulation accuracy validation. The existing way of directly comparing with atomistic solution by MD is limited if the model size is very large. The second is that almost all existing concurrent methods connect FE nodes directly with atomistic boundary. That causes artificial results such as ghost forces.  Now with the new technique by moving FE interface from the atomistic boundary to high-scale particle boundary (see question 7 below) and the new accuracy validation method (see question 8) the concurrent multiscale method should be able to extend to very large model sizes and connecting to existing FE code for structural deformation and failure analysis.  </p>
            <h3>3.	What’s the objective to develop the website https://www.IIMMM.org?</h3>
            <p>A: It is to establish a platform to bring various efforts together to enhance concepts, principles, methodology, skills, information exchange, and software development for wide applications of multiscale analysis. To reach this objective, works of more groups with different methods such as hierarchical modeling, micro-meso-macro continuum scale, and hybrid concurrent-hierarchical multiscale modeling are welcome and will be gradually introduced through this website. </p>
            <h3>4.	Could IIMMM financially support some young scholars for involving multiscale analysis?</h3>
            <p>A: Yes, we are trying to offer limited technical help and money to support students and/or young scholars when they carry on works related to multiscale analysis assigned by their advisors.   </p>
            <h3>5.   Does IIMMM encourage research collaboration? </h3>
            <p>A: Yes. Research collaboration is important to make multiscale analysis more effective including development of new concepts and methods. If one wants to go on in this direction please write some needs in the box of “<a href="/partials/contact.php">Contact”</a></p>
            <h3>6.	Are there any book in multiscale analysis?</h3>
            <ol>
               <li>Jinghong Fan, “<i>Multiscale Analysis of Deformation and Failure of Materials</i>”, Wiley Microsystem and Nanotechnology Series. </li>
               <li>Ellad. B. Tadmor, Modeling Materials: “<i>Continuum, Atomistic and Multiscale Technologies.</i>”</li>
               <li>Weinan E., “<i>Principles of Multiscale Modeling</i>”</li>
               <li>Jacob Fish, “<i>Multiscale Methods: Bridging the Scales in Science and Engineering</i>” </li>
               <li>Andrzej Kolinski, “<i>Multiscale Approaches to Protein Modeling</i>”</li>
            </ol>
            
            <h2 class="ui header">Technical Questions</h2>
            
            <h3 class="ui header">7.	What is the advantage moving the FE interface from the atomistic boundary to high-scale particle boundary?  </h3>
            <p>A: As a consequence of moving the interface far away, any variation or oscillation of the interface or BC will have less disturbance on the atomic motion in the domain of interest, which increases the accuracy, thereby avoiding instability and preventing the effects of artificial phenomena such as the ghost forces from influencing the atomic domain. Secondly, at the high scale particle domain, n, there is a very large generalized lattice constant, an (=an =k(n-1)a0)  . For example, if the particle domain has a scale ratio k=3 and scale level n=3, then the GP method can save about 2 orders of FE element number in the interface domain compared with the DC multiscale method. This is so because DC methods, including QC, require a finite element size equal to the atomic lattice constant in the interface to make the simulation perform well.    </p>
            <h3 class="ui header">8.	What’s the advantage to use existing continuum analytical solution for accuracy validation of atomistically-based multiscale analysis? </h3>
            <p>The significance of comparison between multiscale simulation and continuum solution such as elasticity and LEFM solution is far-reaching, even the multiscale analysis may be extended to other problems where no exact analytical solutions exist. To deeply understand this judgment, one must realize that the accuracy control factors of atomistically-based multiscale modeling are much different from continuum mechanics. For the former, the accuracy mainly depends on the multiscale methodology and the potential used. If the methods, especially the scale-bridging method, is correct and the potential used, such as the EAM potential, is accurate, then its solution should be accurate for wider cases no matter whether the material is with linear or non-linear behavior. </p>
            
            <h2 class="">Frequently Asked Questions (FAQ to GP)</h2>
            
            <h3 class="ui header ">9. What are the basic reasons one can calculate the particle domain &beta; (<small>n</small>)
            by the corresponding atomic domain &alpha;(<small>n</small>) (See Fig. 2 in GP)?  </h3>
            <p>A: This is clarified and realized by the proposed inverse mapping method based on the 
            Cauchy-Born rule and the fact that all scales have the same material crystal structure. 
            Under this condition, the position vectors ri, rj of neighboring atoms i, j in the n 
            domainafter deformation can be determined by the position vectors Ri, Rj of their 
            corresponding generalized particle I and J in the n domain through an inverse mapping. 
            Thus, the inter-atomistic distance rij, interatomic potential and forces, acceleration 
            and velocity can be determined. The obtained atom velocity will be feedback to the 
            corresponding particle domain to determine the new particle position at the next time step. 
            This result is important which makes the numerical method for GP essentially an extension of
            MD with the same potential and can be easily incorporated into applications by modifying 
            existing MD codes.</p>
            
            
            
            <h3 class="ui header ">10. What is the definition and usage of Neighbor Link Cell (NLC) ?</h3>
            <p>A: The NLC of each imaginary particles/atoms in the imaginary domain W(n)image lists all 
            the real particles/atoms within a certain cutoff radius. The neighbors included in the lists 
            are of adjacent scales not of the same scale. For example, an imaginary scale-2 particle will 
            have a list of scale-1 (i.e., atoms) neighbors. This across scale design is necessary to carry 
            on the bottom-up and top-down scale bridging through statistical averaging.   NLC is different 
            from Verlet neighbor lists in MD since it is generated for effectively calculating the inter-atom 
            forces between neighbors. Needless to say, it is at the same scale.     </p>
            
            
            
            
            <h3 class="ui header ">11. What is the advantage moving the FE interface from the atomic boundary to
            high-particle scale boundary ?</h3>
            <p>A: As a consequence of moving the interface far away, any variation or oscillation of the 
            interface or BC will have less disturbance on the atomic motion in the domain of interest, 
            which increases the accuracy, thereby avoiding instability and preventing the effects of 
            artificial phenomenon such as the ghost forces from influencing the atomic domain. 
            Secondly, at the high scale particle domain, n, there is a very large generalized 
            lattice constant, an (=an =k(n-1)a0)  . For example, if the particle domain has a 
            scale ratio k=3 and scale level n=3, then the GP method can save about 2 orders of 
            FE element number in the interface domain compared with the DC multiscale method. 
            This is so because the DC method including QC requires a finite element size equal 
            to the atomic lattice constant in the interface to make the simulation perform well. </p>
            
            
            
            <h3 class="ui header ">12. Any advantage for surface domain (SI) in the GP model ?</h3>
            <p>A: Frequently, free surface causes artificial effects if the model size is to small, especially 
            to high scale models. Using SI layer in the free surface will balance the artificial surface force 
            to obtain correct solution. It is easy to design SI by designing the model size or box size a 
            little larger than the required geometric model.    </p>
            
            
            
            
            <h3 class="ui header ">13. Do you need financial support or donations to support its activity ?</h3>
            <p>A: Financial support is welcome. We hope to get some financial support to support some 
            young investigator or students in China and other countries.  </p>
         </article>
   </section>

<?php include_once "../layout/footer.php"; ?>
