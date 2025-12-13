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
              Chapter
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
    <section>
        <div class="main-width py-10">
            <h2 class="text-center text-[30px] font-medium pb-4">Search for Your State and City and join the chapter</h2>
            <form>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                <input type="text" class="border rounded outline-none px-4 py-3 w-full focus:shadow-[0_0_10px_#CF2031] focus:ring-0" placeholder="Enter State"/>



                 </div>
                <div class="flex gap-4">
                <input type="text" class="border rounded outline-none px-4 py-3 w-full focus:shadow-[0_0_10px_#CF2031] focus:ring-0" placeholder="Enter City"/>
<button class="bg-primary px-6 py-3 text-white rounded ">Go</button>


                 </div>
                
                
                
            </div>
            </form>
            
            <div class="mt-4">
                   <table class="w-full border border-collapse">
                    
                    <thead>
                        <tr class="text-left px-4"  >
                            <th class="p-4 border">
                                S.No.
                            </th>
                            <th class="p-4 border">
                                State
                            </th>
                             <th class="p-4 border">
                                City
                            </th>
                              <th class="p-4 border">
                                Chapter Name
                            </th>
                                <th class="p-4 border">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody id="row">
                       
                    </tbody>
                    
                </table>
                <script>
                    const statesData=[
                        {
                            id:1,
                            State:"Uttar Pradesh",
                            City:"Noida",
                            ChapterName:"Noida01",
                            action:"#"
                        },
                        {
                            id:2,
                            State:"Uttar Pradesh",
                            City:"Greator Noida",
                            ChapterName:"Greator Noida02",
                            action:"#"
                        },
                             {
                            id:3,
                            State:"Uttar Pradesh",
                            City:"Lucknow",
                            ChapterName:"Lucknow01",
                            action:"#"
                        },
                         {
                            id:4,
                            State:"Uttar Pradesh",
                            City:"Varansi",
                            ChapterName:"Varansi01",
                            action:"#"
                        },
                         {
                            id:5,
                            State:"Delhi",
                            City:"Delhi",
                            ChapterName:"Dwarka ",
                            action:"#"
                        },
                     
                      {
                            id:6,
                            State:"Haryana",
                            City:"Gurugram",
                            ChapterName:"Gurugram01",
                            action:"#"
                        },
                       {
                            id:7,
                            State:"Bihar",
                            City:"Patna",
                            ChapterName:"Patna01",
                            action:"#"
                        },
                           {
                            id:8,
                            State:"Jammu and Kashmir",
                            City:"Jammu",
                            ChapterName:"Jammu01",
                            action:"#"
                        },
                        ]
                    
                    
                    const state=statesData.map((data,index)=>(
                        `  
                          <tr >
                          <td class="p-4 border">
                               ${data.id}
                            </td>
                              <td class="p-4 border">
                               ${data.State}
                            </td>
                              <td class="p-4 border">
                               ${data.City}
                            </td>
                               <td class="p-4 border">
                               ${data.ChapterName}
                            </td>
                               <td class="p-4 border">
                               <a href="${data.action}">
                               <span class="px-6 py-2 bg-red-600 text-white rounded">Apply
                               </span>
                               </a>
                            </td>
                          </tr>
                        `
                        
                        ))
                    
                    document.getElementById('row').innerHTML = state.join('');
                    
                    
                </script>
                
             
                
                
            </div>
            
        </div>        
        
        
    </section>
    
    <?php include("components/footer.php") ?>