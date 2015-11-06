module control
implicit none
character(len=80) :: phase
integer :: scales, LoadSteps, Blocks, scale, ncut, NAtoms,MaxListLength,NIdeal,kScale
integer,parameter :: MaxPairsPerAtom=160 
INTEGER(8), DIMENSION(3) :: MCELL
INTEGER, DIMENSION(:), allocatable :: ScaleIndex,AtomTypeIndex,ISolution,IVacancy
INTEGER, DIMENSION(:), allocatable :: HEAD,List,NeighborList,Marker1, Marker2
real(4), dimension(3) :: ModelSize, BoxSize, BasePoint
real(4) :: left,right,back,front,lower,upper,GridSize
real(4), allocatable, dimension(:,:) :: pos
end module control

module phase_data
implicit none
real(4) :: a0,aa,bb,cc
integer :: ncell
real(4), dimension(3,3) :: base
real, allocatable, dimension(:,:) ::cell
integer, dimension(:), allocatable :: anum
real, parameter :: eps=1.e-3
character(len=80), parameter :: DIR="/shared/DATA/crystals/" 
character(len=2), dimension(100) :: stype !different species
end module phase_data

program Mater_Model
use control
implicit none
integer :: i, tmp1, tmp2
character :: ignore
real(4), dimension(3) :: tmp
character(len=30) :: arg1, arg2, InFile
logical :: pickup

if(iargc().eq.1)then
   call getarg(1, arg1)
   InFile=arg1
   pickup=.false.
elseif(iargc().eq.2)then
   call getarg(1, arg1)
   call getarg(2, arg2)
   InFile=arg2
   if (arg1.eq."-p") then
     pickup=.true.
   else
     pickup=.false.
   endif
else
   call help
endif
if (arg1.eq."--help".or.arg1.eq."-h") call help

open(1,file=InFile)
read(1,*) scales, kScale
read(1,*) ModelSize ! box that contains entire model
! would call beam for every scale
read(1,*) Blocks
NAtoms=0
NIdeal=0
open(20,file='Model.xyz')
if (pickup) then
 read(20,*)
 read(20,*)
 do
        read(20,*,end=21,err=20) ignore, tmp, tmp1, tmp2
        NAtoms=NAtoms+1
        if (tmp1.lt.0) NIdeal=NIdeal+1
 enddo
20 write(0,*) "Read Error in Model.xyz"
   call flush(0); call abort
21 continue
else
 write(20,*)
 write(20,*)
 do i=1,Blocks
        write(6,*) 'Block ',i,' is being generated...'; call flush(6)
        read(1,*) phase,scale,ncut
        read(1,*) left,right,back,front,lower,upper
        call beam
        write(6,*) 'real: ',NAtoms, ' Images: ', NIdeal
 enddo
endif
close(20)
close(1)
!END WITH MODEL

!MEMORY PREPARATION
BasePoint=-ModelSize
BoxSize=ModelSize*2.
GridSize=5.2 !roughly the VDW cutoff radius used for imaginary NLC
MCELL=2.*int(ModelSize/GridSize)+1 ! removed the +1 since the version13 GP
                                         !code does not use it, and the GP code works.
allocate(pos(3,NAtoms))
allocate(ScaleIndex(NAtoms))
allocate(AtomTypeIndex(NAtoms))


call NLC_bypass

end program Mater_Model

subroutine Beam
use control
use phase_data
implicit none
integer :: n, depth, nstype, ele
real(4) :: R, x0,y0,z0
real(4), dimension(:,:), allocatable :: vect
integer, dimension(:), allocatable :: typ
logical InX,InY,InZ

real :: a,b,c, slope, re, xc, yc
real :: x,y,z, dist
real, dimension(:,:), allocatable :: cdom
character :: plane
character, dimension(:), allocatable :: cuttype
integer i,j,k,l,m,err, block
integer XSize,YSize,ZSize
logical InBlock,InCut,InBox,InCutBox,hex
integer, dimension(40) :: jlog
!open(10,file='cell')

!call get_phase(phase)
open(13,file=trim(DIR)//trim(phase))
 read(13,*) a0
 read(13,*) aa
 read(13,*) bb
 read(13,*) cc
 read(13,*) hex  ! is it hexagonal?
 read(13,*) base(1,:)
 read(13,*) base(2,:)
 read(13,*) base(3,:)
! write(0,*) a0,aa,bb,cc
! write(0,*) Base(1,:)
! write(0,*) Base(2,:)
! write(0,*) Base(3,:)
! R=sqrt(11.)
! depth=int(R)+1
! n=1
 read(13,*) nstype
 do l=1,nstype
  read(13,*) stype(l), ele
  stype(ele)=stype(l)
 enddo
 read(13,*) ncell
! allocate(anum(ncell))
! allocate(vect(3,ncell))
allocate(cell(3,ncell))
jlog=0
 do l=1,ncell
! read(13,*) vect(:,l), anum(l)
 read(13,*) cell(:,l), jlog(l)
! write(0,*) vect(:,l), anum(l)
 enddo
! do i=-depth,depth
!    do j=-depth,depth
!       do k=-depth,depth
!          do l=1,ncell
!             x=vect(1,l)+float(i)
!             y=vect(2,l)+float(j)
!             z=vect(3,l)+float(k)
!             jlog(n)=anum(l)
   !          if(trim(phase).eq."CuTwin")it=1.0
!             x0=base(1,1)*x+base(1,2)*y+base(1,3)*z*cc
!             y0=base(2,1)*x+base(2,2)*y+base(2,3)*z*cc
!             z0=base(3,1)*x+base(3,2)*y+base(3,3)*z*cc
             !call judge(x0*a0,y0*a0,z0*a0,n,a*a0,b*a0,c*a0,anum(l))
!             InX=(x0*a0)>=0.d0-eps .and. (x0*a0)<(aa*a0)-eps
!             InY=(y0*a0)>=0.d0-eps .and. (y0*a0)<(bb*a0)-eps
!             InZ=(z0*a0)>=0.d0-eps .and. (z0*a0)<(cc*a0)-eps
!             write(0,'(6f24.15,i6)') x,aa,y,bb,z,cc,anum(l)
!             if(InX .and. InY .and. InZ) then
  !              write(10,'(3f24.15,i6)') x0/aa,y0/bb,z0/cc,anum(l)
!             if (.not.hex) then
!             cell(1,n)=x/aa; cell(2,n)=y/bb; cell(3,n)=z/cc; else
!             cell(1,n)=x/aa; cell(2,n)=y/bb; cell(3,n)=z/cc; endif
!                n=n+1
!             endif
!          enddo
!       enddo
!    enddo
! enddo
close(13)
!ncell=n-1
!write(0,*),n
!rewind(10)
a=aa*a0*float(kScale)**(abs(scale)-1)
b=bb*a0*float(kScale)**(abs(scale)-1)
c=cc*a0*float(kScale)**(abs(scale)-1)
write(0,*),"a,b,c", a,b,c
XSize=int(1.415*(ModelSize(1))/a)+1
YSize=int(1.415*(ModelSize(2))/b)+1
ZSize=int(1.415*(ModelSize(3))/c)+1
!left,right,back,front,lower,upper

!allocate(cell(3,ncell))
!jlog=0
!do i=1,ncell
!        read(10,*,iostat=err) cell(1,i),cell(2,i),cell(3,i),j
!        if(err.ne.0)exit
!        jlog(i)=j
!        write(0,*) jlog(i), j
!enddo
!close(10)

allocate(cuttype(ncut))
allocate(cdom(8,ncut))

do m=1,ncut
 read(1,*) cuttype(m)
 if(cuttype(m)=='c') read(1,*) cdom(1:3,m)
 if(cuttype(m)=='e') read(1,*) cdom(1:5,m)
 if(cuttype(m)=='P') read(1,*) cdom(1:4,m)
 if(cuttype(m)=='w') read(1,*) cdom(1:4,m)
 if(cuttype(m)=='T') read(1,*) cdom(1:4,m)
 if(cuttype(m)=='p') read(1,*) cdom(1:8,m)
 if(cuttype(m)=='s') read(1,*) cdom(1:6,m)
 if(cuttype(m)=='r') read(1,*) cdom(1:6,m)
 if(cuttype(m)=='m') then
   read(1,*) plane
   read(1,*) cdom(1:6,m)
 endif
enddo

!do i=-XSize,XSize
!   do j=-YSize,YSize
!      do k=-ZSize,ZSize
write(0,*) left,right,back,front,lower,upper
write(0,*) int(left/a)-1,int(right/a)+1, &
        int(back/b)-1,int(front/b)+1, &
        int(lower/c)-1,int(upper/c)+1
do i=int(left/a)-1,int(right/a)+1
   do j=int(back/b)-1,int(front/b)+1
      do k=int(lower/c)-1,int(upper/c)+1
         do l=1,ncell
            x=( float(i)+cell(1,l) )
            y=( float(j)+cell(2,l) )
            z=( float(k)+cell(3,l) )
            if (hex) then
            ! the a in the second column is because in the true hexagonal system b=a, it 
            ! just has an angle between it. a and c don't change due to andles
             x0=base(1,1)*x*a+base(1,2)*y*a+base(1,3)*z*c
             y0=base(2,1)*x*a+base(2,2)*y*a+base(2,3)*z*c
             z0=base(3,1)*x*a+base(3,2)*y*a+base(3,3)*z*c
            else
            ! use b in the second column for rectangular cells
             x0=base(1,1)*x*a+base(1,2)*y*b+base(1,3)*z*c
             y0=base(2,1)*x*a+base(2,2)*y*b+base(2,3)*z*c
             z0=base(3,1)*x*a+base(3,2)*y*b+base(3,3)*z*c
            endif
             x=x0; y=y0; z=z0
            ! in cut
            InCut=.false.
                do m=1,ncut
                 if(cuttype(m)=='c') then! cut a cylender
                   dist=sqrt((x-cdom(1,m))**2+(z-cdom(2,m))**2)
                   InCut=InCut.or. dist.le.cdom(3,m)
                 elseif(cuttype(m)=='e') then
                   dist=sqrt((x-cdom(1,m))**2+(y-cdom(2,m))**2)
                   slope=( (x-cdom(1,m))*sin(-cdom(5,m)) + (y-cdom(2,m))*cos(-cdom(5,m)) )/ &
                         ( (x-cdom(1,m))*cos(-cdom(5,m)) - (y-cdom(2,m))*sin(-cdom(5,m)) )
                   re=cdom(3,m)*cdom(4,m)*sqrt(slope**2.+1.) &
                      /sqrt(cdom(3,m)**2.*slope**2.+cdom(4,m)**2.)
                   InCut=InCut.or. dist .le. re
                 elseif(cuttype(m)=='P') then !make a pore
                   dist=sqrt((x-cdom(1,m))**2+(y-cdom(2,m))**2+(z-cdom(3,m))**2)
                   InCut=InCut.or. dist.le.cdom(4,m)
                 elseif(cuttype(m)=='w') then !make a sphere
                   dist=sqrt((x-cdom(1,m))**2+(y-cdom(2,m))**2+(z-cdom(3,m))**2)
                   InCut=InCut.or. dist.gt.cdom(4,m)
                 elseif(cuttype(m)=='T') then !make a cylender
                   dist=sqrt((x-cdom(1,m))**2+(y-cdom(2,m))**2)
                   InCut=InCut.or. dist.le.cdom(4,m) .or. dist.gt.cdom(3,m)
                 elseif(cuttype(m)=='p') then
                   xc=(x-((left+right)/2.))*cos(cdom(8,m)) &
                       -(y-((back+front)/2.))*sin(cdom(8,m))
                   yc=(x-((left+right)/2.))*sin(cdom(8,m)) &
                       +(y-((back+front)/2.))*cos(cdom(8,m))
                   x=xc+((left+right)/2.)
                   y=yc+((back+front)/2.)
                   
                   InCutBox=x<=cdom(1,m)-eps .or. x>=cdom(2,m)-eps .or. &
                            y<=cdom(3,m)-eps .or. y>=cdom(4,m)-eps .or. &
                            z<=cdom(5,m)-eps .or. z>=cdom(6,m)-eps
                   InCutBox=InCutBox.or.&
                           (x>=cdom(1,m)-eps+cdom(7,m) .and. x<=cdom(2,m)-eps-cdom(7,m) .and. &
                            y>=cdom(3,m)-eps+cdom(7,m) .and. y<=cdom(4,m)-eps-cdom(7,m) )
                   InCut=InCut.or. InCutBox
                 elseif(cuttype(m)=='r') then
                  if(m.eq.1)InCut=.true.
                   xc=(x-(cdom(1,m)))*cos(cdom(6,m)) &
                       -(y-(cdom(2,m)))*sin(cdom(6,m))
                   yc=(x-(cdom(1,m)))*sin(cdom(6,m)) &
                       +(y-(cdom(2,m)))*cos(cdom(6,m))
                   xc=xc+(cdom(1,m))
                   yc=yc+(cdom(2,m))
                   
                   dist=sqrt((xc-cdom(1,m))**2+(yc-cdom(2,m))**2)
                   slope=( (xc-cdom(1,m))*sin(-cdom(5,m)) + (yc-cdom(2,m))*cos(-cdom(5,m)) )/ &
                         ( (xc-cdom(1,m))*cos(-cdom(5,m)) - (yc-cdom(2,m))*sin(-cdom(5,m)) )
                   re=cdom(3,m)*cdom(4,m)*sqrt(slope**2.+1.) &
                      /sqrt(cdom(3,m)**2.*slope**2.+cdom(4,m)**2.)
                   !InCut=InCut.or. dist .le. re
                   if (dist .le. re) then
                     InCut=.false.
                     x=xc; y=yc
                   !else
                   !  InCut=.true.
                   endif
                 elseif(cuttype(m)=='v') then
                   InCutBox=x<=cdom(1,m)-eps .or. x>=cdom(2,m)-eps .or. &
                            y<=cdom(3,m)-eps .or. y>=cdom(4,m)-eps .or. &
                            z<=cdom(5,m)-eps .or. z>=cdom(6,m)-eps
                   InCutBox=InCutBox.or.&
                           (x>=cdom(1,m)-eps+cdom(7,m) .and. x<=cdom(2,m)-eps-cdom(7,m) .and. &
                            y>=cdom(3,m)-eps+cdom(7,m) .and. y<=cdom(4,m)-eps-cdom(7,m) )
                   InCut=InCut.or. (.not.InCutBox)
                 elseif(cuttype(m)=='s') then
                   InCutBox=x>=cdom(1,m)-eps .and. x<=cdom(2,m)-eps .and. &
                            y>=cdom(3,m)-eps .and. y<=cdom(4,m)-eps .and. &
                            z>=cdom(5,m)-eps .and. z<=cdom(6,m)-eps
                   InCut=InCut.or. InCutBox
                 elseif(cuttype(m)=='m') then!mirror for twins
                   InCutBox=x>=cdom(1,m)-eps .and. x<=cdom(2,m)-eps .and. &
                            y>=cdom(3,m)-eps .and. y<=cdom(4,m)-eps .and. &
                            z>=cdom(5,m)-eps .and. z<=cdom(6,m)-eps
                   if (InCutBox) then
                     if(plane.eq.'x')then
                       x=cdom(2,m)-abs(cdom(1,m)-x)
                     elseif(plane.eq.'y')then
                       y=cdom(4,m)-abs(cdom(3,m)-y)
                     elseif(plane.eq.'z')then
                       z=cdom(6,m)-abs(cdom(5,m)-z)
                     else
                       write(0,*) "2:plane must be specified for a mirror, use either [x,y,z]"
                     endif
                   endif
                 endif
                enddo !m=1,ncut
            ! in general model domain
            InBox=x.ge.-ModelSize(1)-eps .and. x.lt.ModelSize(1)-eps .and. &
                  y.ge.-ModelSize(2)-eps .and. y.lt.ModelSize(2)-eps .and. &
                  z.ge.-ModelSize(3)-eps .and. z.lt.ModelSize(3)-eps
            !  in actual block
            InBlock=x>=left-eps .and. x<=right-eps .and. &
                    y>=back-eps .and. y<=front-eps .and. &
                    z>=lower-eps .and. z<=upper-eps

            if(InBox.and.InBlock.and. .not.InCut) then
               write(20,*) stype(jlog(l)),x,y,z,scale,jlog(l)
               NAtoms=NAtoms+1
               if (scale.lt.0) NIdeal=NIdeal+1
            endif
         enddo !l=1,ncell
      enddo !k=-ZSize,ZSize
   enddo !j=-YSize,YSize
enddo !i=-XSize,XSize

deallocate(cell)
deallocate(cuttype)
deallocate(cdom)
! deallocate(anum)
! deallocate(vect)
!rewind(20) !reset the pointer for this file

end subroutine Beam

subroutine get_phase(phase)
use phase_data
implicit none
integer :: i,j,k,l,n, depth, nstype, ele
character(len=80) :: phase
real(4) :: R, x0,y0,z0,x,y,z
real(4), dimension(:,:), allocatable :: vect
integer, dimension(:), allocatable :: typ
logical InX,InY,InZ
open(13,file=trim(DIR)//trim(phase))
 read(13,*) a0
 read(13,*) aa
 read(13,*) bb
 read(13,*) cc
 read(13,*) base(1,:)
 read(13,*) base(2,:)
 read(13,*) base(3,:)
! write(0,*) a0,aa,bb,cc
! write(0,*) Base(1,:)
! write(0,*) Base(2,:)
! write(0,*) Base(3,:)
 R=sqrt(11.)
 depth=int(R)+1
 n=0
 read(13,*) nstype
 do l=1,nstype
  read(13,*) stype(l), ele
  stype(ele)=stype(l)
 enddo
 read(13,*) ncell
 allocate(anum(ncell))
 allocate(vect(3,ncell))
 do l=1,ncell
 read(13,*) vect(:,l), anum(l)
! write(0,*) vect(:,l), anum(l)
 enddo
 do i=-depth,depth
    do j=-depth,depth
       do k=-depth,depth
          do l=1,ncell
             x=vect(1,l)+float(i)
             y=vect(2,l)+float(j)
             z=vect(3,l)+float(k)
             !if(trim(phase).eq."CuTwin")
             x0=base(1,1)*x+base(1,2)*y+base(1,3)*z*cc
             y0=base(2,1)*x+base(2,2)*y+base(2,3)*z*cc
             z0=base(3,1)*x+base(3,2)*y+base(3,3)*z*cc
!             call judge(x0*a0,y0*a0,z0*a0,n,a*a0,b*a0,c*a0,anum(l))
             InX=(x0*a0)>=0.d0-eps .and. (x0*a0)<(aa*a0)-eps
             InY=(y0*a0)>=0.d0-eps .and. (y0*a0)<(bb*a0)-eps
             InZ=(z0*a0)>=0.d0-eps .and. (z0*a0)<(cc*a0)-eps
!             write(0,'(6f24.15,i6)') x,aa,y,bb,z,cc,anum(l)
             if(InX .and. InY .and. InZ) then
                write(10,'(3f24.15,i6)') x0/aa,y0/bb,z0/cc,anum(l)
                n=n+1
             endif
          enddo
       enddo
    enddo
 enddo
close(13)
ncell=n
write(0,*),n
end subroutine get_phase

subroutine help
implicit none

write(0,*) "This program builds Molecular and General Particle Models to be"
write(0,*) " simulated with the GP code and is in the process of making models for DL_POLY"
write(0,*) "Usage: Mater_Model.exe model.in"
write(0,*) "The file 'model.in' is the input file for this program. It is"
write(0,*) "composed of geometric domains for different scales and materials. See the"
write(0,*) "example file."
end subroutine help
         
subroutine NLC_bypass
use control
use phase_data
implicit none
integer :: cntKept, cntIdeal, i
character(len=2) :: ignore

!Read the model from that xyz file
open(20,file='Model.xyz') 
read(20,*)                
read(20,*)                
do i=1,NAtoms               
        read(20,*) ignore, pos(:,i),ScaleIndex(i),AtomTypeIndex(i)
        pos(:,i)=pos(:,i)/BoxSize+0.5
        if(ScaleIndex(i)<0) CntIdeal=CntIdeal+1         ! Count the numebr of ideal atoms/paticles
enddo                  
close(20) 

!!!!!!!!!! FIRST PASS !!!!!!!!!!!!!!!!!!!
open(4,file="Model.xyz")
write(4,*) NAtoms
write(4,*)
cntIdeal=0
cntKept=0
do i=1,NAtoms
   if(ScaleIndex(i)<0) then ! if it's imaginary
      cntIdeal=cntIdeal+1
      write(4,*) ' H',(pos(:,i)-0.5)*BoxSize,ScaleIndex(i),AtomTypeIndex(i)
      cntKept=cntKept+1
   else
      write(4,*) stype(AtomTypeIndex(i)),(pos(:,i)-0.5)*BoxSize,ScaleIndex(i),AtomTypeIndex(i)
   endif !(ScaleIndex(i)<0)
enddo !i=1,NAtoms
close (4)

!Read the model from that xyz file
open(20,file='Model.xyz') 
read(20,*)                
read(20,*)                
do i=1,NAtoms               
        read(20,*) ignore, pos(:,i),ScaleIndex(i),AtomTypeIndex(i)
        pos(:,i)=pos(:,i)/BoxSize+0.5
        if(ScaleIndex(i)<0) CntIdeal=CntIdeal+1         ! Count the numebr of ideal atoms/paticles
enddo                  
close(20) 

!!!!!!!!!!! SECOND PASS !!!!!!!!!!!!!!!!!!!!
open(4,file="Model.MD")
write(4,'(3i8)') scales,NAtoms,NAtoms-cntKept
write(4,'(a1,3f24.15)') 'F',BoxSize
cntIdeal=0
cntKept=0
do i=1,NAtoms
   if(ScaleIndex(i)<0) then ! if it's imaginary
      cntIdeal=cntIdeal+1
      write(4,'(3f24.15,2i5)') (pos(:,i)-0.5)*BoxSize,abs(ScaleIndex(i)),-AtomTypeIndex(i)
      write (4,'(i8,3f14.6)') 0, (/0.0,0.0,0.0/)
   !      write(4,'(i8,3f12.6)') 0, (/0.0,0.0,0.0/)
      cntKept=cntKept+1
   else
      write(4,'(3f24.15,2i5)') (pos(:,i)-0.5)*BoxSize,ScaleIndex(i),AtomTypeIndex(i)
   endif !(ScaleIndex(i)<0)
enddo !i=1,NAtoms
close (4)
write(0,*), 'Totally ', NAtoms,' atoms/particles exist'
write(0,*), 'Totally ', cntIdeal,' ideal atoms/particles exist'
write(0,*), cntIdeal-cntKept,' ideal atoms/particles cannot find symmetric neighbors'

call exit
end subroutine NLC_bypass


