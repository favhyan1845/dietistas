<?php
ob_start();
get_header();
    /******
     *GET info provider class
     * @return array******/
class ProfileView
{
    private $slug;
    private $slugs;
    function __construct(){        
        $this->slugUrl = get_query_var('profile_slug');
        $this->slugsDB = get_option('healthloft-profile-response-cache-slug');
        $this->urlProviders = get_option('healthloft-profile-response-url');
    }
    function profile(){
        foreach($this->slugsDB as $key => $slug){
            if($slug == $this->slugUrl){                    
                $urlProvider = $this->urlProviders.'/'.$key;
                $infoProvider = $this->apiResponse($urlProvider);
                return $infoProvider ['data'];
            }
        }
    }

    function apiResponse($url){
        $response = wp_remote_get($url);
        if (is_wp_error($response)) {
            echo 'Error en la solicitud: ' . $response->get_error_message();
            return;
        }
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        return $data;
    }
}

$provider = new ProfileView();
$profile = $provider->profile();

if (empty($profile)) {
    header("Location: /", true, 307);
    exit; // usa 'exit' en lugar de 'die' para seguir buenas prácticas
}

?>
<section class="flex w-full flex-col bg-background">
    <main class="flex justify-center">
        <section class="mt-12 flex w-full flex-col items-center">
            <section
                class="mb-10 flex w-11/12 flex-col justify-center rounded-md border bg-white p-4 text-left md:w-120">
                <div class="flex w-full justify-start">
                    <a href="javascript:window.history.back()" class="flex"><svg xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="h-6 w-6 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
                        </svg></a>
                </div>
                <div class="mb-6 flex flex-col items-center"><img class="mb-2 h-32 w-32 rounded-full object-cover"
                        src="<?php echo $profile['avatarUrl'] ?>" alt="Avatar">
                    <h1 class="font-manrope text-3xl font-semibold"><?php echo $profile['name']; ?>
                    </h1>
                    <p class="text-sm font-light uppercase text-gray-500">
                        <?php echo $profile['education'] ?>
                    </p>
                </div>
                <div class="mb-4 flex flex-col">
                    <h2 class="mb-2 font-manrope text-base font-bold">Age ranges</h2>
                    <div class="flex flex-wrap">
                        <div class="flex flex-wrap">
                            <?php
                            foreach ($profile['ageRanges'] as $ageRange) {
                                ?>
                            <div
                                class="mb-2 mr-2 rounded-full px-3 py-1 text-xs font-semibold text-white bg-[#15435a66]">
                                <?php echo $ageRange['name']; ?>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="mb-4 flex flex-col">
                    <h2 class="mb-2 font-manrope text-base font-bold" id="specialities">Specialities</h2>
                    <div class="flex flex-wrap">
                        <div class="flex flex-wrap" id="tags-container">
                            <?php
                            $count = 0;
                            foreach ($profile['tags'] as $tag) {
                                if ($count < 8) {
                                    ?>
                            <div
                                class="mb-2 mr-2 rounded-full bg-cobalt px-3 py-1 text-xs font-semibold text-white tag-item">
                                <?php echo $tag['name']; ?>
                            </div>
                            <?php
                                    $count++;
                                } else {
                                    break;
                                }
                            } ?>
                        </div>
                        <?php
                        if (count($profile['tags']) > 10) {
                            ?>
                        <div class="flex cursor-pointer items-center text-sm text-gray-500 underline hover:opacity-80"
                            id="show-more-btn">
                            Show more</div>
                        <?php }
                        ?>
                        <div class="flex cursor-pointer items-center text-sm text-gray-500 underline hover:opacity-80"
                            id="show-less-btn">
                            Show less</div>
                    </div>
                </div>

                <div class="mt-4 flex justify-center"><a href="https://join.healthloftco.com/" target="_blank"
                        class="px-6 py-2 text-black rounded-md focus:outline-none text-center"
                        style="background-color: rgb(168, 230, 255); border: 1px solid rgb(168, 230, 255);">Book
                        Now</a></div><br>
                <div class="flex flex-col justify-between">

                    <?php
                    foreach ($profile['sections'] as $section) {
                        ?>
                    <div class="mb-4 flex flex-col">
                        <h2 class="mb-2 font-manrope text-xl font-semibold">
                            <?php echo $section['title']; ?>
                        </h2>
                        <p class="text-sm">
                            <?php echo $section['content']; ?>
                        </p>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="mt-4 flex flex-col justify-between">
                    <div class="mb-3 flex flex-col">
                        <h3 class="font-manrope text-xs font-semibold uppercase">Locations</h3>
                        <div class="mt-1 flex w-full flex-wrap">
                            <?php
                            foreach ($profile['states'] as $state) {
                                ?>
                            <div
                                class="mr-2 mt-2 rounded-full bg-skyBlueGray px-2 py-1 text-xs font-semibold text-white">
                                <?php echo $state; ?>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="mb-3 flex flex-col">
                        <?php
                        foreach ($profile['additionalSections'] as $additionalSection) {
                            ?>
                        <div class="mb-3 flex flex-col">
                            <h3 class="font-manrope text-xs font-semibold uppercase">
                                <?php echo $additionalSection['title']; ?>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                <?php echo $additionalSection['content']; ?>
                            </p>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        </section>
    </main>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // show tags
    $('#show-more-btn').on('click', function() {
        const allTags = <?php echo json_encode($profile['tags']); ?>;
        const $container = $('#tags-container');
        const currentCount = $container.find('.tag-item').length;
        const limit = allTags.length;

        for (let i = currentCount; i < currentCount + limit && i < allTags.length; i++) {
            const tagDiv = $('<div></div>')
                .addClass(
                    'mb-2 mr-2 rounded-full bg-cobalt px-3 py-1 text-xs font-semibold text-white tag-item'
                )
                .text(allTags[i]['name']);
            $container.append(tagDiv);
        }
        $('#show-more-btn').css('display', 'none');
        $('#show-less-btn').css('display', 'block');

        const targetIndex = Math.max($container.find('.tag-item').length - 12, 0);

        $('html, body').animate({
            scrollTop: $container.find('.tag-item').eq(targetIndex).offset().top
        }, 3000);
    });
    // hidden tags
    $('#show-less-btn').on('click', function() {

        const allTags = <?php echo json_encode($profile['tags']); ?>;
        const $container = $('#tags-container');
        const currentCount = $container.find('.tag-item').length;
        const limit = allTags.length - 8;

        if (currentCount > 0) {
            for (let i = 0; i < limit && currentCount - i - 1 >= 0; i++) {
                $container.find('.tag-item').last().remove();
            }
        }
        $('#show-more-btn').css('display', 'block');
        $('#show-less-btn').css('display', 'none');

        if ($container.find('.tag-item').length === 0) {
            $(this).hide();
        }
        $('html, body').animate({
            scrollTop: $('#specialities').offset().top
        }, 3000);
    });
});
</script>
<?php
get_footer();
ob_end_flush();
?>