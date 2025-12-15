@include("user.components.meta")
@include("user.components.header")
    <section
      class="bg-[url(images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat"
    > <div class="w-full py-10 h-full banner-grid"> 
      <div class="main-width h-full py-4 flex items-center lg:justify-start">
        <div class=" wgrid grid-cols-[58%,1fr] gap-6 items-center">
          <div h-full>
            <p
              class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]"
            >
             Path of Business networking and Growth
            </p>
            <div class="w-full ">
              <span class="heading2 bg-primary text-white py-2 px-7">
              Our Sponsors
              </span>
            </div>
            <p
              class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"
            >
             Empowering Brands with Premium Visibility & Engagement (sponsorship)
            </p>
          </div>
          
        </div>
      </div>
      </div>
    </section>

<section class="bg-[#f2f2f2] py-10">

<div class="base-template main-width py-10 md:py-4 ">
	<div class=" md:grid grid-cols-1">
<div class="text-[#232323]">
                       <div>
                        <!--<span class="px-4 py-2 bg-red-600/10 text-red-600 text-sm  rounded">-->
                        <!--   TEAM. CUSTOMER. COMMUNITY-->
                        <!--</span>-->
                    </div>
           <!--<h2 class="font-semibold py-2 text-[20px] md:text-[30px] ">-->
           <!--       We Work With the Best Sponsers-->
           <!--  </h2>-->
                      <p
              class=" lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"
            >
                  
At Top Management Network (TMN), we offer exclusive sponsorship opportunities for brands that want to engage with industry leaders, business executives, and top professionals. As a TMN sponsor, you gain access to a highly targeted and influential audience, allowing your brand to establish credibility, enhance visibility, and generate valuable business connections.
                    </p>
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