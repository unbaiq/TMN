<?php include("components/meta.php")?>
<?php include("components/header.php")?>
    <section
      class="bg-[url(images/banner.png)] bg-cover py-10 lg:bg-right bg-center bg-no-repeat"
    >
      <div class="main-width h-full py-4 flex items-center lg:justify-center">
        <div class="grid md:grid-cols-[68%,1fr] gap-6 items-center">
          <div h-full>
            <p
              class="text-white lg:py-3 py-2 lg:text-[25px] text-[17px] font-normal lg:leading-[25px]"
            >
              Path to Business Growth.
            </p>
            <div class="w-full py-4">
              <span class="heading2  px-6 py-4 bg-[rgba(207,32,49,0.80)]  text-white py-2 px-2 leading-[60px]">
               TMNians Story
              </span>
            </div>
            <p
              class="text-white lg:py-3 py-2 lg:text-[19px] text-[17px] font-normal lg:leading-[30px]"
            >
              Have a question or need more information? Whether you're interested in membership, learning about Chapters, or exploring franchise opportunities, we're here to help. Reach out, and our team will connect you with the right resources.  
            </p>
          </div>
       
        </div>
      </div>
    </section>
    <section class="py-10">
        <div class="main-width">
            <p class="text-[#232323]">
                Top Management network ensures CXO under one roof to share thoughts , ideology , challenges and create an ecosystem where discussion can happen over cup of coffee. We will be positioning TMN in India and across aisa pac and middle east region in 2024-25.<br><br>

<span class="font-bold">Top Management network</span> is a group of top management people who come under one roof to share thoughts, ideology, challenges and create an environment where discussion can happen over a cup of coffee. TMN is founded with a vision to enhance business, develop skills and create an environment for interactions among the top management of similar or diverse fields.
One of the main aims of TMN is to contribute towards mentoring the budding entrepreneurs /startups and enable them to handle business challenges in a better way.
            </p>
            
            
            
        </div>
        <div class="main-width pt-10  grid lg:grid-cols-3 md:grid-cols-2  gap-6" id="storydata">
          <script>
    const storydata = [
        {
            img: "images/rcure.png", 
            dis: "Indian retail pharma sector is huge and ensures space for many players. In fact one of the largest and fastest growing in the world.",
            name: "Rupinder Kaur",
            cname: "Revival Health Care Pvt. Ltd.",
            link: "detail-stories.php"
        },
           {
            img: "images/locads.png", 
            dis: "TheLocads is a co-brand of Enigma, it allows customers to extend their reach to end customers by sharing product information and offers at will.",
            name: "Avinash Handoo",
            cname: "Enigma Exhibition Pvt. Ltd.",
            link: "detail-stories.php"
        },
           {
            img: "images/travel.png", 
            dis: "Enjoy the walk within Monument using our Virtual guide. Walk Through Monument and access information through The Travel Talk App.",
            name: "Satish Chandra Srivastava",
            cname: "The Travel Talk",
            link: "detail-stories.php"
        },
    ];

    const data = storydata.map((data, index) => (
        `<div key="${index}" class="rounded-br-[40px] py-6 border rounded-br-[40px] shadow-[0px_4px_20px_0px_rgba(129,129,129,0.25)] over flow-hidden  bg-[#fff]   overflow-hidden bg-[#fff]">
            <div class="w-full h-[150px]">
                <img src="${data.img}" class="w-full h-full object-contain" alt="">
            </div>
            <div class="p-4 h-full text-left">
                <p class="font-medium lg:leading-[25px] leading-[19px] text-[#232323]  text-[16px]">
                    ${data.dis}
                </p>
                <hr class="w-[80%] my-4 border-[#CF2031] border-2 ">
                <p class="font-bold xl:leading-[30px] text-[#232323] text-[21px]">
                    ${data.name}
                </p>
                <p class="font-medium xl:leading-[30px] text-[16px]">
                    ${data.cname}
                </p>
                <div class="mt-4">
                <a href="${data.link} " class="text-[#fff] mt-4 bg-[#CF2031] px-4 py-3 ">Read More &nbsp;<i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>`
    ));

    document.getElementById("storydata").innerHTML = data.join('');
</script>
        </div>
        
        
        
    </section>
    <?php include('components/footer.php') ?>