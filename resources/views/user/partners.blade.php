@include("user.components.meta")
@include("user.components.header")
    <section
      class="bg-[url(images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat"
    > <div class="w-full py-10 h-full banner-grid"> 
      <div class="main-width h-full py-4 flex items-center lg:justify-start">
        <div class="wgrid md:grid w-full md:grid-cols-[58%,1fr] gap-6 items-center">
          <div h-full>
            <p
              class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]"
            >
             Path of Business networking and Growth
            </p>
            <div class="w-full ">
              <span class="heading2 bg-primary text-white py-2 px-7">
              Our Partners
              </span>
            </div>
            <p
              class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"
            >
             Building Stronger Networks Through Strategic Partnerships
            </p>
          </div>
          
        </div>
      </div>
      </div>
    </section>

<section class="bg-[#f2f2f2] py-10">

<div class=" main-width py-10 md:py-4 ">
	<div class=" md:grid grid-cols-1">
<div class="text-[#232323]">
                       <div>
                        <!--<span class="px-4 py-2 bg-red-600/10 text-red-600 text-sm  rounded">-->
                        <!--   TEAM. CUSTOMER. COMMUNITY-->
                        <!--</span>-->
                    </div>
           <!--<h2 class="font-semibold py-2  text-[20px] md:text-[30px]  ">-->
           <!--       We Work With the Best Partners-->
           <!--  </h2>-->
                      <p
              class=" lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"
            >
                  

At Top Management Network (TMN), we believe in the power of collaboration. Our partners play a crucial role in helping us create an ecosystem that fosters innovation, leadership, and professional growth. By working alongside top industry organizations, business associations, and corporate leaders, we create impactful opportunities for professionals, entrepreneurs, and business leaders to expand their networks and accelerate their success.
                    </p>
                    <br>
                    
                    <div class="w-full ">
              <span class=" cursor-pointer bg-primary text-white py-2 px-7">
              Our Partners
              </span>
            </div>
            <br>
            <p
              class=" lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"
            >If you’re looking to expand your influence, drive industry innovation, and connect with top professionals, TMN is the right platform for you. Let’s work together to shape the future of business and leadership</p>
                </div>

 <div class="grid grid-cols-6 gap-6 items-center mt-10" id="partners">
          <script>
            const committeImage = [
              { img: "images/partners/casio.png",  },
               { img: "images/partners/fijustu.png",  },
                { img: "images/partners/Philips.png",  },
                 { img: "images/partners/toshi.png",  },
                 { img: "images/partners/casio.png",  },
               { img: "images/partners/fijustu.png",  },
                { img: "images/partners/Philips.png",  },
                 { img: "images/partners/toshi.png",  },
                 { img: "images/partners/casio.png",  },
               { img: "images/partners/fijustu.png",  },
                { img: "images/partners/Philips.png",  },
                 { img: "images/partners/toshi.png",  },
                 { img: "images/partners/casio.png",  },
               { img: "images/partners/fijustu.png",  },
                { img: "images/partners/Philips.png",  },
                 { img: "images/partners/toshi.png",  },
                 { img: "images/partners/casio.png",  },
               { img: "images/partners/fijustu.png",  },
                { img: "images/partners/Philips.png",  },
                 { img: "images/partners/toshi.png",  },
                 { img: "images/partners/casio.png",  },
               { img: "images/partners/fijustu.png",  },
                { img: "images/partners/Philips.png",  },
                 { img: "images/partners/toshi.png",  },
         
              
            ];
        
            const htmlContent = committeImage.map((data, index) => (
              ` 
              <div class=" rounded cursor-pointer  hover:shadow h-[100px] flex items-center justify-center transition-all duration-300 ease-in hover:bg-[#fff]  transform hover:scale-105">
              <img src="${data.img}" class=" object-contain w-[60%] mx-auto   " alt="" />
              </div>`
            ));

            document.getElementById("partners").innerHTML = htmlContent.join('');
          </script>
          
        </div>
	
	</div>
</div>
</section>

 
@include("user.components.footer")