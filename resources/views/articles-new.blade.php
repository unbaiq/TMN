  <?php 
  ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include("config/config.php");
include("components/meta.php")?>
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
              Stories
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
        <section class="py-10 text-[#232323] bg-[#f2f2f2]">
              
        <div class="main-width  ">
            <div  class="grid grid-cols-[65%,1fr] gap-8">
                <div>
                    
<style>
        .container {
            display: flex;
            flex-wrap: wrap;
        }
        .item {
            margin: 20px;
            padding: 20px;
            border: 1px solid #000;
            width: 100%;
            max-width: 600px;
        }
        .clip-design img {
            width: 100%;
            height: auto;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination button {
            margin: 0 5px;
            padding: 10px 20px;
        }
    </style>


<?php
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$itemsPerPage = 2;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($currentPage - 1) * $itemsPerPage;

$sql = "SELECT * FROM `article` LIMIT $start, $itemsPerPage";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="container">';
    while($row = $result->fetch_assoc()) {
        echo '<div class="bg-white shadow border mt-10">';
        echo '<div class="relative bg-white">';
        echo '<div class="clip-design">';
       echo '<img src="'.$row['image'].'" class="w-full h-full" alt=""/>';
 // Adjust image path as needed
        echo '</div>';
        echo '<div class="absolute bottom-2 pl-10 pt-8">';
        echo '<div class="mb-[2px]">';
        $date = new DateTime($row['created_at']);
$formattedDate = $date->format('F jS, Y');
echo '<span class="text-sm ">'.$formattedDate.'</span>';
 // Adjust column name as needed
        echo '</div>';
        echo '<span class="text-[#CF2031] ">'.$row['author'].'</span>'; // Adjust column name as needed
        echo '</div>';
        echo '</div>';
        echo '<div class="px-8 pb-8">';
        echo '<h2 class="text-[#232323] font-medium text-[35px] ">'.$row['title'].'</h2>'; // Adjust column name as needed
        echo '<p class="text-[16px] font-normal lg:leading-[30px]">'.$row['description'].'</p>'; // Adjust column name as needed
        echo '<div class="py-4 mt-4">';
        echo '<a href="'.$row['href'].'"><span class="bg-red-600 rounded shadow text-white px-4 py-2 text-[17px] ">Continue Reading...</span></a>';
        echo '</div>';
        echo '<div class="flex items-center gap-2 mt-3">';
        echo '<div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] transform hover:scale-110 rounded shadow rounded-full text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] "><i class="fa-brands fa-facebook-f"></i></div>';
        echo '<div class="border-red-600 border transform hover:scale-110 flex items-center justify-center w-[40px] h-[40px] rounded shadow rounded-full text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] "><i class="fa-brands fa-instagram"></i></div>';
        echo '<div class="border-red-600 border transform hover:scale-110 flex items-center justify-center w-[40px] h-[40px] rounded shadow rounded-full text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] "><i class="fa-brands fa-x-twitter"></i></div>';
        echo '<div class="border-red-600 border transform hover:scale-110 flex items-center justify-center w-[40px] h-[40px] rounded shadow rounded-full text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] "><i class="fa fa-envelope"></i></div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "No results";
}

$sqlTotal = "SELECT COUNT(*) as total FROM `story`";
$resultTotal = $conn->query($sqlTotal);
$rowTotal = $resultTotal->fetch_assoc();
$totalPages = ceil($rowTotal['total'] / $itemsPerPage);

echo '<div class="pagination">';
// Display current page number and total pages
// Display current page number and total pages
echo 'Page ' . $currentPage . ' of ' . $totalPages . '<br>';

// Previous button
if ($currentPage > 1) {
    echo '<button onclick="window.location.href=\'?page=' . ($currentPage - 1) . '\'">Previous</button>';
}

// Page number buttons
for ($i = 1; $i <= $totalPages; $i++) {
    if ($i == $currentPage) {
        echo '<button class="bg-red-400 text-white px-4 py-2 m-1">' . $i . '</button>';
    } else {
        echo '<button class="bg-black text-white px-4 py-2 m-1" onclick="window.location.href=\'?page=' . $i . '\'">' . $i . '</button>';
    }
}

// Next button
if ($currentPage < $totalPages) {
    echo '<button onclick="window.location.href=\'?page=' . ($currentPage + 1) . '\'">Next</button>';
}

echo '</div>';

$conn->close();
?>


             
                </div>
                <div class="">
                    <div>
                        <div class="px-4">
                            <h2 class="text-[#232323] font-normal text-[25px] ">
                                About TMN
                            </h2>
                            <hr class="w-[40%] border-[2px]  mt-2 border-[#CF2031]">
                            <p class="text-[#232323] pt-6">
                                With three decades of glorious experience in creating interiors of palaces and masterpieces in the Middle-East, Mr P.N.C. Menon founded SOBHA Limited in 1995 with a clear vision to transform the way people perceive quality. Today, SOBHA is the most trusted brand and only backward integrated real estate player in the country. <br><br>

                                   As on 31st March 2020, the company has delivered overall 109.74 million square feet of developable area. The company has a real estate presence in 10 cities, viz. Bengaluru, Gurugram, Chennai, Pune, Coimbatore, Thrissur, Kozhikode, Kochi, Gujarat (Gift City) and Mysore. Overall, SOBHA has footprint in 27 cities in 14 states across India.
                                    <br><br>
                                   As on 31st March 2020, the company has delivered overall 109.74 million square feet of developable area. 
                            </p>
                        </div>
                        
                        
                    </div>
                   
                       <div class="px-4 mt-14">
                            <h2 class="text-[#232323] font-normal text-[25px] ">
                                Social
                            </h2>
                            <hr class="w-[20%] border-[2px] mt-2 border-[#CF2031]">
                    <div class="flex items-center gap-2 mt-3">
                        <div class="border-red-600 border flex items-center justify-center w-[40px] h-[40px] transform hover:scale-110 rounded shadow rounded-full  text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] "><i class="fa-brands fa-facebook-f"></i></div>
                         <div class="border-red-600 border transform hover:scale-110 flex items-center justify-center w-[40px] h-[40px] rounded shadow rounded-full  text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] "><i class="fa-brands fa-instagram"></i></div>
                          <div class="border-red-600 border transform hover:scale-110 flex items-center justify-center w-[40px] h-[40px] rounded shadow rounded-full  text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] "><i class="fa-brands fa-twitter"></i></div>
                           <div class="border-red-600 border transform hover:scale-110  flex items-center justify-center w-[40px] h-[40px] rounded shadow rounded-full  text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] "><i class="fa-regular fa-envelope"></i></div>
                             <div class="border-red-600 border transform hover:scale-110  flex items-center justify-center w-[40px] h-[40px] rounded shadow rounded-full  text-[#CF2031] cursor-pointer duration-700 transition-all hover:bg-[#CF2031] hover:text-white text-[17px] "><i class="fa-brands fa-youtube"></i></div>
                    </div>
                    
                    
                    
                </div>
                
                 <div class="px-4 mt-14">
                            <h2 class="text-[#232323] font-normal text-[22px] ">
                               Latest Story
                            </h2>
                            <hr class="w-[20%] border-[2px] mt-2 border-[#CF2031]">
                    <div class=" gap-2 mt-3" id="Posts">
                        
                        <script>
  const Postsdata = [
    { 
      img: "https://goodmockups.com/wp-content/uploads/2021/02/Free-Corporate-Building-3D-Logo-Mockup-PSD.jpg",
      subdis: "What is Patta and Chitta? A Complete Guide for Landowners in Tamil Nadu",
      date: "February 5th, 2025",
      link: "#"
    },
      { 
      img: "https://static.vecteezy.com/system/resources/thumbnails/044/825/424/small/pattern-of-office-buildings-windows-illuminated-at-night-glass-architecture-corporate-building-at-night-business-concept-photo.JPG",
      subdis: "What is Patta and Chitta? A Complete Guide for Landowners in Tamil Nadu",
      date: "February 5th, 2025",
      link: "#"
    },
      { 
      img: "https://st.depositphotos.com/1279189/1383/i/450/depositphotos_13838778-stock-photo-industrial-warehouse.jpg",
      subdis: "What is Patta and Chitta? A Complete Guide for Landowners in Tamil Nadu",
      date: "February 5th, 2025",
      link: "#"
    },
      { 
      img: "https://goodmockups.com/wp-content/uploads/2021/02/Free-Corporate-Building-3D-Logo-Mockup-PSD.jpg",
      subdis: "What is Patta and Chitta? A Complete Guide for Landowners in Tamil Nadu",
      date: "February 5th, 2025",
      link: "#"
    }
  ];

  const postContent = Postsdata.map((data, index) => (
    `      <div class="grid grid-cols-[100px,1fr] mt-4 gap-4" key="${index}">
              <div class="h-[90px] w-full">
                  <img src="${data.img}" class="h-full w-full object-cover" alt="Post image"/>
              </div>
              <div>
                  <h4 class="text-[#232323] font-medium ">
                      ${data.subdis}
                  </h4>
                  <p class="text-gray-600 py-1">
                     ${data.date}
                  </p>
              </div>
            </div>`
  ));

  document.getElementById("Posts").innerHTML = postContent.join('');
</script>

                        
                        
                        
                        
                        
                  
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-14">
        <div class="main-width">
            <div class="mb-6">
               <h2 class="text-[#232323] font-semibold text-[30px] ">
                               Previous Article
                            </h2>
                  </div>         
               <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10" id="articles">
          <script>
            const articlesData = [
              { img: "https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F945485643%2F2567913917311%2F1%2Foriginal.20250127-134635?crop=focalpoint&fit=crop&w=512&auto=format%2Ccompress&q=75&sharp=10&fp-x=0.550724637681&fp-y=0.0350318471338&s=d001b3f3b32ce9f60fb8089c076e46a1",
                tag:" Sunday",
                date:"Feb 09 , 9:30 PM",
                head: "Live The Night ",
                subdis: "Come join us at LUNET CLUB for an unforgettable Night filled with Bigroom music, dancing, Nostalgia, EDM community and good vibes......",
                link:"detailed-event.php"
                  
              },
              { img: "https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F945485643%2F2567913917311%2F1%2Foriginal.20250127-134635?crop=focalpoint&fit=crop&w=512&auto=format%2Ccompress&q=75&sharp=10&fp-x=0.550724637681&fp-y=0.0350318471338&s=d001b3f3b32ce9f60fb8089c076e46a1",
                tag:" Sunday",
                date:"Feb 09 , 9:30 PM",
                head: "Live The Night ",
                subdis: "Come join us at LUNET CLUB for an unforgettable Night filled with Bigroom music, dancing, Nostalgia, EDM community and good vibes......",
                link:"detailed-event.php"
                  
              },
           
             
            ];
        
            const htmlContent = articlesData.map((data, index) => (
              ` <div class="h-[380px] group border overflow-hidden rounded-xl shadow-xl w-[340px] relative cursor-pointer">
                <img class="w-full h-full transition-all duration-700  transform group-hover:scale-110 " src="${data.img}">
                <div class="absolute duration-700 ease-in  group-hover:h-[300px]  bg-white bottom-0 w-full h-[120px] p-6">
                    <div class="flex items-center justify-between">
                        <span class="px-4 py-2 bg-red-600/10 text-red-600 text-sm  rounded font-medium">
                            ${data.tag}
                        </span>
                        <span class="font-medium">
                           ${data.date}
                        </span>
                    </div>
                    <h2 class="font-semibold py-4 text-[20px]">
                           
                 ${data.head} 
                    </h2>
                    <p class="text-sm">
                  ${data.subdis}
                    </p>
                    <div class="mt-3">   
                    <a href="${data.link}">
                    <span class="bg-red-600 text-white px-4 py-2  text-[13px] ">Join Now</span>
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