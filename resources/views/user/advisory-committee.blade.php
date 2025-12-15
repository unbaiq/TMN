@include("user.components.meta")
@include("user.components.header")
    <section
      class="bg-[url(images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat"
    > <div class="w-full py-10 h-full banner-grid"> 
      <div class="main-width h-full py-4 flex items-center lg:justify-start">
        <div class="grid w-full md:grid-cols-[68%,1fr] gap-6 items-center">
          <div h-full>
            <p
              class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]"
            >
             Path of Business networking and Growth
            </p>
            <div class="w-full ">
              <span class="heading2 bg-primary text-white py-2 px-7">
              Advisory Committee
              </span>
            </div>
            <p
              class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"
            >
             Meet the Experts Behind TMN’s Success
            </p>
          </div>
          
        </div>
      </div>
      </div>
    </section>
        <section class="pt-10 text-[#232323] bg-[#f2f2f2]">
        <div class="main-width">
        <p class="leading-[25px] text-[16px]">
            <span class="font-bold">Top Management Network</span> (TMN), we believe that great leadership thrives on expert guidance and strategic insights. Our Advisory Panel is composed of highly accomplished business leaders, industry veterans, and subject matter experts who bring unparalleled experience and wisdom to our network. These advisors play a pivotal role in mentoring entrepreneurs, executives, and professionals, helping them navigate challenges and achieve long-term growth.
           
            <br> <br>
<b><p>Meet Our Esteemed Advisors</p></b><br>
Our advisory board consists of renowned business leaders, successful entrepreneurs, corporate strategists, and financial experts. These professionals contribute their expertise to empower TMN members and guide them towards growth, profitability, and leadership excellence.
<br> <br>
Each advisor brings unique strengths, ranging from business development and financial planning to marketing strategies and operational efficiency. With their mentorship, TMN members can confidently make decisions that drive sustainable business success.
        </p>
        </div>
    
    </section>
    
   <section class="py-10 bg-[#f2f2f2]">
       <div class="main-width grid lg:grid-cols-2 gap-4 mt-4" id="articles">
           <script>
            const articlesData = [
              { img: "images/rita.png",
                name:" Rita Sharma",
                deg:"  CEO",
                head: "Enhance Mobility with Evekare’s Walkers and Rollators ",
                dis: "Top Management network is a group of top management people who come under one roof to share thoughts, ideology, challenges and create an environment where discussion can happen over a cup of coffee",
                link:"#"
                  
              },
               { img: "images/suzan.png",
                name:" Suzan",
                deg:"  CEO",
                head: "Enhance Mobility with Evekare’s Walkers and Rollators ",
                dis: "Top Management network is a group of top management people who come under one roof to share thoughts, ideology, challenges and create an environment where discussion can happen over a cup of coffee",
                link:"#"
                  
              },
               { img: "images/rita.png",
                name:" Rita Sharma",
                deg:"  CEO",
                head: "Enhance Mobility with Evekare’s Walkers and Rollators ",
                dis: "Top Management network is a group of top management people who come under one roof to share thoughts, ideology, challenges and create an environment where discussion can happen over a cup of coffee",
                link:"#"
                  
              },
               { img: "images/suzan.png",
                name:" Suzan",
                deg:"  CEO",
                head: "Enhance Mobility with Evekare’s Walkers and Rollators ",
                dis: "Top Management network is a group of top management people who come under one roof to share thoughts, ideology, challenges and create an environment where discussion can happen over a cup of coffee",
                link:"#"
                  
              },
             
            ];
        
            const htmlContent = articlesData.map((data, index) => (
              `
                  <div class="grid xl:grid-cols-[30%,1fr] md:grid-cols-[50%,1fr] gap-2 transition-all duration-700  hover:shadow-md bg-[#fff]   p-4">
               <div class="w-full pt-4">
                   <img src="${data.img}" alt="" class="w-[160px] mx-auto h-[160px] rounded-full  object-cover" >
                   <div class=" w-full w-[60%] mx-auto flex ktems-center justify-around py-2 text-[#232323]">
                   <span class="border-red-600 border transform hover:scale-110 flex items-center justify-center w-[40px] h-[40px] rounded shadow rounded-full  text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] ">
                   <i class="fa-brands   fa-linkedin-in"></i>
                   </span>
                   <span class="border-red-600 border transform hover:scale-110 flex items-center justify-center w-[40px] h-[40px] rounded shadow rounded-full  text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] ">
                   <i class="fa-solid fa-share"></i>
                   </span>
                   
                   </div>
               </div>
                <div class="p-2">
                    <h2 class="text-[21px] font-bold leading-[25px]">
                       ${data.name}
                    </h2>
                    <h4  class="text-[16px] font-normal leading-[25px]">
                      ${data.deg}
                    </h4>
                    <p class="pt-4">
                        ${data.dis}
                    </p>
                    <a href="${data.link}">
                    <p class="flex pt-4 items-center font-bold leading-[24px] text-primary ">
                        Read More <svg xmlns="http://www.w3.org/2000/svg" width="34" height="33" viewBox="0 0 34 33" fill="none">
  <path d="M17.2123 16.7654H5.95288V18.6404H17.2123V21.4529L20.9529 17.7029L17.2123 13.9529V16.7654Z" fill="#CF2031"/>
</svg>
                    </p>
                    </a>
                </div>
               
               
               
           </div>
            `
            ));

            document.getElementById("articles").innerHTML = htmlContent.join('');
          </script>

       </div>
        </div>
   </section>

   @include("user.components.footer")