  <?php include("components/meta.php")?>
<?php include("components/header.php")?>
    <section
      class="bg-[url(images/committee-banner.png)] bg-cover lg:bg-right bg-center bg-no-repeat"
    > <div class="w-full py-10 h-full banner-grid"> 
      <div class="main-width h-full py-4 flex items-center lg:justify-start">
        <div class="grid md:grid-cols-[58%,1fr] gap-6 items-center">
          <div h-full>
            <p
              class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]"
            >
             Path to Business Growth.
            </p>
            <div class="w-full ">
              <span class="heading2 bg-primary text-white py-2 px-7">
              Articles
              </span>
            </div>
            <p
              class="text-white lg:py-3 py-2 lg:text-[19px] text-[16px] font-normal lg:leading-[30px]"
            >
             Have a question or need more information? Whether you're interested in membership, learning about Chapters, or exploring franchise opportunities, we're here to help. Reach out, and our team will connect you with the right resources.  
            </p>
          </div>
          
        </div>
      </div>
      </div>
    </section>
        <section class="py-10 text-[#232323]">
        <div class="main-width ">
            <div class="pb-10">
              <p class=" font-light leading-[25px]">
                    Walkers and rollators serve as invaluable aids for individuals with mobility issues, providing stability, support, and confidence while walking. These devices are designed to offer balance, reduce the risk of falls, and allow people to move around more comfortably. 

By incorporating walkers and rollators into daily life, individuals can regain their independence, engage in physical activities, and enjoy a higher level of mobility.
<br>
There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                    
                </p>
            </div>
            
              <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10" id="articles">
          <script>
            const articlesData = [
              { img: "https://evekare.com/AU/media/Walkers-and-wheel-chairs.jpg",
                tag:" WALKING AID",
                head: "Enhance Mobility with Evekare’s Walkers and Rollators ",
                subdis: "Maintaining mobility is crucial for individuals of all ages, especially those who face challenges in walking or require assistance for better stability.  Evekare, a renowned provider of bathroom.....",
                link:"details-article.php"
                  
              },
              { img: "https://evekare.com/AU/media/Walkers-and-wheel-chairs.jpg",
                tag:" WALKING AID",
                head: "Enhance Mobility with Evekare’s Walkers and Rollators ",
                subdis: "Maintaining mobility is crucial for individuals of all ages, especially those who face challenges in walking or require assistance for better stability.  Evekare, a renowned provider of bathroom.....",
                link:"details-article.php"
                  
              },
              { img: "https://evekare.com/AU/media/Walkers-and-wheel-chairs.jpg",
                tag:" WALKING AID",
                head: "Enhance Mobility with Evekare’s Walkers and Rollators ",
                subdis: "Maintaining mobility is crucial for individuals of all ages, especially those who face challenges in walking or require assistance for better stability.  Evekare, a renowned provider of bathroom.....",
                link:"details-article.php"
                  
              },
              { img: "https://evekare.com/AU/media/Walkers-and-wheel-chairs.jpg",
                tag:" WALKING AID",
                head: "Enhance Mobility with Evekare’s Walkers and Rollators ",
                subdis: "Maintaining mobility is crucial for individuals of all ages, especially those who face challenges in walking or require assistance for better stability.  Evekare, a renowned provider of bathroom.....",
                link:"details-article.php"
                  
              },
             
            ];
        
            const htmlContent = articlesData.map((data, index) => (
              ` <div class="h-[380px] group border overflow-hidden rounded-xl shadow-xl w-[340px] relative cursor-pointer">
                <img class="w-full h-full transition-all duration-700  transform group-hover:scale-110 " src="${data.img}">
                <div class="absolute duration-700 ease-in  group-hover:h-[300px]  bg-white bottom-0 w-full h-[120px] p-6">
                    <div>
                        <span class="px-4 py-2 bg-red-600/10 text-red-600 text-sm  rounded">
                            ${data.tag}
                        </span>
                    </div>
                    <h2 class="font-semibold py-4">
                           
                 ${data.head} 
                    </h2>
                    <p class="text-sm">
                  ${data.subdis}
                    </p>
                    <div class="mt-3">   
                    <a href="${data.link}">
                    <span class="bg-red-600 text-white px-4 py-2  text-[13px] ">Read More..</span>
                    </a>
                    </div>

                </div>
                
            </div>`
            ));

            document.getElementById("articles").innerHTML = htmlContent.join('');
          </script>
          
        </div>
            
            
            
           
       
        </div>
    
    </section>
    <?php include('components/footer.php') ?>