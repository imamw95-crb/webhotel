<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GalleryImagesSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            // ===== ROOM TYPES (rooms) =====
            // Deluxe
            ['title' => 'Deluxe Room', 'image_path' => 'room-types/deluxe/IMG_20260302_144057.jpg', 'category' => 'Deluxe', 'sort_order' => 1],
            ['title' => 'Deluxe Room - Angle 2', 'image_path' => 'room-types/deluxe/IMG_20260302_144243.jpg', 'category' => 'Deluxe', 'sort_order' => 2],
            ['title' => 'Deluxe Room - Angle 3', 'image_path' => 'room-types/deluxe/IMG_20260302_144417.jpg', 'category' => 'Deluxe', 'sort_order' => 3],
            ['title' => 'Deluxe Room - Angle 4', 'image_path' => 'room-types/deluxe/IMG_20260302_144551.jpg', 'category' => 'Deluxe', 'sort_order' => 4],
            ['title' => 'Deluxe Room - Angle 5', 'image_path' => 'room-types/deluxe/IMG_20260302_144558.jpg', 'category' => 'Deluxe', 'sort_order' => 5],

            // Executive
            ['title' => 'Executive Room', 'image_path' => 'room-types/executive/IMG_20260315_154622_380.jpg', 'category' => 'Executive', 'sort_order' => 6],
            ['title' => 'Executive - Angle 2', 'image_path' => 'room-types/executive/IMG_20260315_154645_649.jpg', 'category' => 'Executive', 'sort_order' => 7],
            ['title' => 'Executive - Angle 3', 'image_path' => 'room-types/executive/IMG_20260315_154656_154.jpg', 'category' => 'Executive', 'sort_order' => 8],
            ['title' => 'Executive - Angle 4', 'image_path' => 'room-types/executive/IMG_20260315_154701_711.jpg', 'category' => 'Executive', 'sort_order' => 9],
            ['title' => 'Executive - Angle 5', 'image_path' => 'room-types/executive/IMG_20260315_154717_012.jpg', 'category' => 'Executive', 'sort_order' => 10],
            ['title' => 'Executive - Angle 6', 'image_path' => 'room-types/executive/IMG_20260315_154721_502.jpg', 'category' => 'Executive', 'sort_order' => 11],
            ['title' => 'Executive - Angle 7', 'image_path' => 'room-types/executive/IMG_20260315_154802_635.jpg', 'category' => 'Executive', 'sort_order' => 12],
            ['title' => 'Executive - Angle 8', 'image_path' => 'room-types/executive/IMG_20260315_154807_196.jpg', 'category' => 'Executive', 'sort_order' => 13],
            ['title' => 'Executive - Angle 9', 'image_path' => 'room-types/executive/IMG_20260315_154826_654.jpg', 'category' => 'Executive', 'sort_order' => 14],
            ['title' => 'Executive - Angle 10', 'image_path' => 'room-types/executive/IMG_20260315_154834_106.jpg', 'category' => 'Executive', 'sort_order' => 15],
            ['title' => 'Executive - Angle 11', 'image_path' => 'room-types/executive/IMG_20260315_154854_693.jpg', 'category' => 'Executive', 'sort_order' => 16],
            ['title' => 'Executive - Angle 12', 'image_path' => 'room-types/executive/IMG_20260315_154857_235.jpg', 'category' => 'Executive', 'sort_order' => 17],
            ['title' => 'Executive - Angle 13', 'image_path' => 'room-types/executive/IMG_20260315_154920_856.jpg', 'category' => 'Executive', 'sort_order' => 18],
            ['title' => 'Executive - Angle 14', 'image_path' => 'room-types/executive/IMG_20260315_154933_811.jpg', 'category' => 'Executive', 'sort_order' => 19],
            ['title' => 'Executive - Angle 15', 'image_path' => 'room-types/executive/IMG_20260315_154938_913.jpg', 'category' => 'Executive', 'sort_order' => 20],
            ['title' => 'Executive - Angle 16', 'image_path' => 'room-types/executive/IMG_20260315_154944_061.jpg', 'category' => 'Executive', 'sort_order' => 21],
            ['title' => 'Executive - Angle 17', 'image_path' => 'room-types/executive/IMG_20260315_154956_507.jpg', 'category' => 'Executive', 'sort_order' => 22],
            ['title' => 'Executive - Angle 18', 'image_path' => 'room-types/executive/IMG_20260315_154958_868.jpg', 'category' => 'Executive', 'sort_order' => 23],
            ['title' => 'Executive - Angle 19', 'image_path' => 'room-types/executive/IMG_20260315_155006_039.jpg', 'category' => 'Executive', 'sort_order' => 24],
            ['title' => 'Executive - Panorama', 'image_path' => 'room-types/executive/IMG_20260402_183846_8_Panorama.jpg.jpeg', 'category' => 'Executive', 'sort_order' => 25],
            ['title' => 'Executive - Panorama 2', 'image_path' => 'room-types/executive/IMG_20260402_183924_9_Panorama.jpg.jpeg', 'category' => 'Executive', 'sort_order' => 26],
            ['title' => 'Executive - View 1', 'image_path' => 'room-types/executive/ChatGPT Image May 10, 2026, 01_02_55 PM.png', 'category' => 'Executive', 'sort_order' => 27],
            ['title' => 'Executive - View 2', 'image_path' => 'room-types/executive/file_0000000081a07208a07e5d23c28ab938.png', 'category' => 'Executive', 'sort_order' => 28],
            ['title' => 'Executive - View 3', 'image_path' => 'room-types/executive/file_00000000b3a472089a668c87ca137a58.png', 'category' => 'Executive', 'sort_order' => 29],

            // Family
            ['title' => 'Family Room', 'image_path' => 'room-types/family-107/IMG_20260312_134525_513.jpg', 'category' => 'Family', 'sort_order' => 30],
            ['title' => 'Family Room - Angle 2', 'image_path' => 'room-types/family-107/IMG_20260315_123836_808.jpg', 'category' => 'Family', 'sort_order' => 31],
            ['title' => 'Family Room - Angle 3', 'image_path' => 'room-types/family-107/IMG_20260315_123839_982.jpg', 'category' => 'Family', 'sort_order' => 32],
            ['title' => 'Family Room - Angle 4', 'image_path' => 'room-types/family-107/IMG_20260315_123856_093.jpg', 'category' => 'Family', 'sort_order' => 33],
            ['title' => 'Family Room - Angle 5', 'image_path' => 'room-types/family-107/IMG_20260315_123857_614.jpg', 'category' => 'Family', 'sort_order' => 34],
            ['title' => 'Family Room - Angle 6', 'image_path' => 'room-types/family-107/IMG_20260315_123931_764.jpg', 'category' => 'Family', 'sort_order' => 35],
            ['title' => 'Family Room - Angle 7', 'image_path' => 'room-types/family-107/IMG_20260315_124010_394.jpg', 'category' => 'Family', 'sort_order' => 36],
            ['title' => 'Family Room - Angle 8', 'image_path' => 'room-types/family-107/IMG_20260315_124032_868.jpg', 'category' => 'Family', 'sort_order' => 37],
            ['title' => 'Family Room - Panorama', 'image_path' => 'room-types/family-107/IMG_20260402_132744_4_Panorama.jpg.jpeg', 'category' => 'Family', 'sort_order' => 38],
            ['title' => 'Family Room - View 1', 'image_path' => 'room-types/family-107/ChatGPT Image May 10, 2026, 01_09_44 PM.png', 'category' => 'Family', 'sort_order' => 39],
            ['title' => 'Family Room - View 2', 'image_path' => 'room-types/family-107/Picsart_26-04-02_18-06-43-629.jpg.jpeg', 'category' => 'Family', 'sort_order' => 40],
            ['title' => 'Family Room - View 3', 'image_path' => 'room-types/family-107/file_00000000f9847208a5155dab2d3cbfc6.png', 'category' => 'Family', 'sort_order' => 41],

            // Superior
            ['title' => 'Superior Room', 'image_path' => 'room-types/superior-109/IMG_20260315_124433_350.jpg', 'category' => 'Superior', 'sort_order' => 42],
            ['title' => 'Superior Room - Angle 2', 'image_path' => 'room-types/superior-109/IMG_20260315_124442_170.jpg', 'category' => 'Superior', 'sort_order' => 43],
            ['title' => 'Superior Room - Angle 3', 'image_path' => 'room-types/superior-109/IMG_20260315_124515_128.jpg', 'category' => 'Superior', 'sort_order' => 44],
            ['title' => 'Superior Room - Angle 4', 'image_path' => 'room-types/superior-109/IMG_20260315_124536_558.jpg', 'category' => 'Superior', 'sort_order' => 45],
            ['title' => 'Superior Room - Angle 5', 'image_path' => 'room-types/superior-109/IMG_20260315_124606_759.jpg', 'category' => 'Superior', 'sort_order' => 46],
            ['title' => 'Superior Room - Angle 6', 'image_path' => 'room-types/superior-109/IMG_20260315_124615_998.jpg', 'category' => 'Superior', 'sort_order' => 47],

            // Junior
            ['title' => 'Junior Suite', 'image_path' => 'room-types/junior/junior-205/IMG_20260302_092144_155@1865609329.jpg', 'category' => 'Junior', 'sort_order' => 48],
            ['title' => 'Junior Suite - Angle 2', 'image_path' => 'room-types/junior/junior-205/IMG_20260302_092207_080@-1078917936.jpg', 'category' => 'Junior', 'sort_order' => 49],
            ['title' => 'Junior Suite - Angle 3', 'image_path' => 'room-types/junior/junior-205/IMG_20260302_092253_777@-1526208234.jpg', 'category' => 'Junior', 'sort_order' => 50],
            ['title' => 'Junior Suite - Angle 4', 'image_path' => 'room-types/junior/junior-205/IMG_20260302_092309_482@1356050841.jpg', 'category' => 'Junior', 'sort_order' => 51],
            ['title' => 'Junior Suite - Angle 5', 'image_path' => 'room-types/junior/junior-205/IMG_20260302_092336_080@-1657955347.jpg', 'category' => 'Junior', 'sort_order' => 52],
            ['title' => 'Junior Suite - Angle 6', 'image_path' => 'room-types/junior/junior-205/IMG_20260302_092403_556@-1675765316.jpg', 'category' => 'Junior', 'sort_order' => 53],
            ['title' => 'Junior Suite - Angle 7', 'image_path' => 'room-types/junior/junior-205/IMG_20260302_092414_441@-305516425.jpg', 'category' => 'Junior', 'sort_order' => 54],
            ['title' => 'Junior Suite - Angle 8', 'image_path' => 'room-types/junior/junior-205/IMG_20260302_092441_031@948662574.jpg', 'category' => 'Junior', 'sort_order' => 55],
            ['title' => 'Junior Suite - Angle 9', 'image_path' => 'room-types/junior/junior-205/IMG_20260302_092504_468@-1842231330.jpg', 'category' => 'Junior', 'sort_order' => 56],

            // ===== FACILITIES / GALLERY =====
            // Swimming Pool
            ['title' => 'Swimming Pool', 'image_path' => 'gallery/swimming-pool/ChatGPT Image May 28, 2026, 10_25_33 AM.png', 'category' => 'Swimming Pool', 'sort_order' => 57],

            // Fitness & Gym
            ['title' => 'Fitness & Gym', 'image_path' => 'gallery/fitness-gym/IMG_20260315_150318_768.jpg', 'category' => 'Fitness', 'sort_order' => 58],
            ['title' => 'Fitness & Gym - Angle 2', 'image_path' => 'gallery/fitness-gym/IMG_20260315_150323_303.jpg', 'category' => 'Fitness', 'sort_order' => 59],
            ['title' => 'Fitness & Gym - Angle 3', 'image_path' => 'gallery/fitness-gym/IMG_20260315_150349_603.jpg', 'category' => 'Fitness', 'sort_order' => 60],
            ['title' => 'Fitness & Gym - Angle 4', 'image_path' => 'gallery/fitness-gym/IMG_20260315_150432_532.jpg', 'category' => 'Fitness', 'sort_order' => 61],
            ['title' => 'Fitness & Gym - Angle 5', 'image_path' => 'gallery/fitness-gym/IMG_20260315_150445_830.jpg', 'category' => 'Fitness', 'sort_order' => 62],
            ['title' => 'Fitness & Gym - Angle 6', 'image_path' => 'gallery/fitness-gym/IMG_20260315_150448_295.jpg', 'category' => 'Fitness', 'sort_order' => 63],

            // Garden
            ['title' => 'Garden', 'image_path' => 'gallery/garden/IMG_20260315_132458_725.jpg', 'category' => 'Garden', 'sort_order' => 64],
            ['title' => 'Garden - Angle 2', 'image_path' => 'gallery/garden/IMG_20260315_132523_256.jpg', 'category' => 'Garden', 'sort_order' => 65],
            ['title' => 'Garden - Angle 3', 'image_path' => 'gallery/garden/IMG_20260315_132828_269.jpg', 'category' => 'Garden', 'sort_order' => 66],
            ['title' => 'Garden - Angle 4', 'image_path' => 'gallery/garden/IMG_20260315_150614_145.jpg', 'category' => 'Garden', 'sort_order' => 67],
            ['title' => 'Garden - Angle 5', 'image_path' => 'gallery/garden/IMG_20260315_150617_330.jpg', 'category' => 'Garden', 'sort_order' => 68],
            ['title' => 'Garden - Angle 6', 'image_path' => 'gallery/garden/IMG_20260315_150701_360.jpg', 'category' => 'Garden', 'sort_order' => 69],
            ['title' => 'Garden - Angle 7', 'image_path' => 'gallery/garden/IMG_20260315_150704_268.jpg', 'category' => 'Garden', 'sort_order' => 70],
            ['title' => 'Garden - Angle 8', 'image_path' => 'gallery/garden/IMG_20260315_150712_493.jpg', 'category' => 'Garden', 'sort_order' => 71],
            ['title' => 'Garden - Angle 9', 'image_path' => 'gallery/garden/IMG_20260315_150714_765.jpg', 'category' => 'Garden', 'sort_order' => 72],
            ['title' => 'Garden - Angle 10', 'image_path' => 'gallery/garden/IMG_20260315_151101_772.jpg', 'category' => 'Garden', 'sort_order' => 73],
            ['title' => 'Garden - Angle 11', 'image_path' => 'gallery/garden/IMG_20260315_151104_027.jpg', 'category' => 'Garden', 'sort_order' => 74],
            ['title' => 'Garden - Angle 12', 'image_path' => 'gallery/garden/IMG_20260315_154226_121.jpg', 'category' => 'Garden', 'sort_order' => 75],

            // Lobby
            ['title' => 'Lobby', 'image_path' => 'gallery/lobby/IMG_20260315_123014_195.jpg', 'category' => 'Lobby', 'sort_order' => 76],
            ['title' => 'Lobby - Angle 2', 'image_path' => 'gallery/lobby/IMG_20260315_123019_728.jpg', 'category' => 'Lobby', 'sort_order' => 77],
            ['title' => 'Lobby - Angle 3', 'image_path' => 'gallery/lobby/IMG_20260315_155116_371.jpg', 'category' => 'Lobby', 'sort_order' => 78],
            ['title' => 'Lobby - Angle 4', 'image_path' => 'gallery/lobby/IMG_20260315_155119_288.jpg', 'category' => 'Lobby', 'sort_order' => 79],
            ['title' => 'Lobby - Angle 5', 'image_path' => 'gallery/lobby/IMG_20260506_145626_439.jpg', 'category' => 'Lobby', 'sort_order' => 80],

            // Resto
            ['title' => 'Resto', 'image_path' => 'gallery/resto/ChatGPT Image Apr 1, 2026, 10_25_51 AM.jpg', 'category' => 'Resto', 'sort_order' => 81],
            ['title' => 'Resto - Foto Bagus', 'image_path' => 'gallery/resto/FOTO BAGUS.jpg', 'category' => 'Resto', 'sort_order' => 82],
            ['title' => 'Resto - Angle 2', 'image_path' => 'gallery/resto/IMG_20260315_123122_569.jpg', 'category' => 'Resto', 'sort_order' => 83],
            ['title' => 'Resto - Angle 3', 'image_path' => 'gallery/resto/IMG_20260315_123125_429.jpg', 'category' => 'Resto', 'sort_order' => 84],
            ['title' => 'Resto - Angle 4', 'image_path' => 'gallery/resto/IMG_20260315_132542_952.jpg', 'category' => 'Resto', 'sort_order' => 85],
            ['title' => 'Resto - Angle 5', 'image_path' => 'gallery/resto/IMG_20260315_151121_266.jpg', 'category' => 'Resto', 'sort_order' => 86],
            ['title' => 'Resto - Angle 6', 'image_path' => 'gallery/resto/IMG_20260315_151132_560.jpg', 'category' => 'Resto', 'sort_order' => 87],
            ['title' => 'Resto - Angle 7', 'image_path' => 'gallery/resto/IMG_20260315_151200_537.jpg', 'category' => 'Resto', 'sort_order' => 88],
            ['title' => 'Resto - Angle 8', 'image_path' => 'gallery/resto/IMG_20260410_171800_593.jpg (1).jpeg', 'category' => 'Resto', 'sort_order' => 89],
            ['title' => 'Resto - Angle 9', 'image_path' => 'gallery/resto/IMG_20260414_160302_316.jpg.jpeg', 'category' => 'Resto', 'sort_order' => 90],
            ['title' => 'Resto - Romantic Dinner', 'image_path' => 'gallery/resto/ROMANTIC DINNER 4.png', 'category' => 'Resto', 'sort_order' => 91],
            ['title' => 'Resto - Romantic Dinner 2', 'image_path' => 'gallery/resto/ROMANTIC DINNER.png', 'category' => 'Resto', 'sort_order' => 92],

            // Stone Terrace
            ['title' => 'Stone Terrace', 'image_path' => 'gallery/stone-terrace/IMG_20260227_115235_059.jpg', 'category' => 'Stone Terrace', 'sort_order' => 93],
            ['title' => 'Stone Terrace - Angle 2', 'image_path' => 'gallery/stone-terrace/IMG_20260227_115259_374.jpg', 'category' => 'Stone Terrace', 'sort_order' => 94],
            ['title' => 'Stone Terrace - Angle 3', 'image_path' => 'gallery/stone-terrace/IMG_20260315_124853_685.jpg', 'category' => 'Stone Terrace', 'sort_order' => 95],

            // Depan Hotel
            ['title' => 'Depan Hotel', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191002_644.jpg', 'category' => 'Depan Hotel', 'sort_order' => 96],
            ['title' => 'Depan Hotel - 2', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191011_941.jpg', 'category' => 'Depan Hotel', 'sort_order' => 97],
            ['title' => 'Depan Hotel - 3', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191037_129.jpg', 'category' => 'Depan Hotel', 'sort_order' => 98],
            ['title' => 'Depan Hotel - 4', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191103_040.jpg', 'category' => 'Depan Hotel', 'sort_order' => 99],
            ['title' => 'Depan Hotel - 5', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191107_373.jpg', 'category' => 'Depan Hotel', 'sort_order' => 100],
            ['title' => 'Depan Hotel - 6', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191127_548.jpg', 'category' => 'Depan Hotel', 'sort_order' => 101],
            ['title' => 'Depan Hotel - 7', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191402_746.jpg', 'category' => 'Depan Hotel', 'sort_order' => 102],
            ['title' => 'Depan Hotel - 8', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191517_445.jpg', 'category' => 'Depan Hotel', 'sort_order' => 103],
            ['title' => 'Depan Hotel - 9', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191525_083.jpg', 'category' => 'Depan Hotel', 'sort_order' => 104],
            ['title' => 'Depan Hotel - 10', 'image_path' => 'gallery/depan-hotel/IMG_20260315_191744_187.jpg', 'category' => 'Depan Hotel', 'sort_order' => 105],
            ['title' => 'Depan Hotel - 11', 'image_path' => 'gallery/depan-hotel/IMG_20260315_192021_250.jpg', 'category' => 'Depan Hotel', 'sort_order' => 106],
            ['title' => 'Depan Hotel - 12', 'image_path' => 'gallery/depan-hotel/IMG_20260315_192059_486.jpg', 'category' => 'Depan Hotel', 'sort_order' => 107],
            ['title' => 'Depan Hotel - 13', 'image_path' => 'gallery/depan-hotel/IMG_20260315_192126_458.jpg', 'category' => 'Depan Hotel', 'sort_order' => 108],
            ['title' => 'Depan Hotel - 14', 'image_path' => 'gallery/depan-hotel/IMG_20260315_192217_027.jpg', 'category' => 'Depan Hotel', 'sort_order' => 109],
            ['title' => 'Depan Hotel - 15', 'image_path' => 'gallery/depan-hotel/IMG_20260315_192224_715.jpg', 'category' => 'Depan Hotel', 'sort_order' => 110],
            ['title' => 'Depan Hotel - 16', 'image_path' => 'gallery/depan-hotel/IMG_20260315_192432_593.jpg', 'category' => 'Depan Hotel', 'sort_order' => 111],
            ['title' => 'Depan Hotel - 17', 'image_path' => 'gallery/depan-hotel/IMG_20260315_192447_679.jpg', 'category' => 'Depan Hotel', 'sort_order' => 112],
            ['title' => 'Depan Hotel - 18', 'image_path' => 'gallery/depan-hotel/IMG_20260315_192448_891.jpg', 'category' => 'Depan Hotel', 'sort_order' => 113],
            ['title' => 'Depan Hotel - 19', 'image_path' => 'gallery/depan-hotel/IMG_20260315_192524_365.jpg', 'category' => 'Depan Hotel', 'sort_order' => 114],
            ['title' => 'Depan Hotel - 20', 'image_path' => 'gallery/depan-hotel/IMG_20260315_193035_172.jpg', 'category' => 'Depan Hotel', 'sort_order' => 115],
            ['title' => 'Depan Hotel - 21', 'image_path' => 'gallery/depan-hotel/IMG_20260315_193306_432.jpg', 'category' => 'Depan Hotel', 'sort_order' => 116],
            ['title' => 'Depan Hotel - 22', 'image_path' => 'gallery/depan-hotel/IMG_20260315_193425_162.jpg', 'category' => 'Depan Hotel', 'sort_order' => 117],
            ['title' => 'Depan Hotel - 23', 'image_path' => 'gallery/depan-hotel/IMG_20260315_193432_150.jpg', 'category' => 'Depan Hotel', 'sort_order' => 118],
            ['title' => 'Depan Hotel - 24', 'image_path' => 'gallery/depan-hotel/IMG_20260315_193532_835.jpg', 'category' => 'Depan Hotel', 'sort_order' => 119],
            ['title' => 'Depan Hotel - 25', 'image_path' => 'gallery/depan-hotel/IMG_20260315_194250_979.jpg', 'category' => 'Depan Hotel', 'sort_order' => 120],
            ['title' => 'Depan Hotel - 26', 'image_path' => 'gallery/depan-hotel/IMG_20260315_194300_587.jpg', 'category' => 'Depan Hotel', 'sort_order' => 121],
            ['title' => 'Depan Hotel - 27', 'image_path' => 'gallery/depan-hotel/IMG_20260315_194326_075.jpg', 'category' => 'Depan Hotel', 'sort_order' => 122],

            // Tampak Depan
            ['title' => 'Tampak Depan Hotel', 'image_path' => 'gallery/tampak-depan/IMG_20260302_093513_414@-249047492.jpg', 'category' => 'Tampak Depan', 'sort_order' => 123],
            ['title' => 'Tampak Depan - 2', 'image_path' => 'gallery/tampak-depan/IMG_20260302_093519_644@-642944863.jpg', 'category' => 'Tampak Depan', 'sort_order' => 124],
            ['title' => 'Tampak Depan - 3', 'image_path' => 'gallery/tampak-depan/IMG_20260307_194925_415.jpg', 'category' => 'Tampak Depan', 'sort_order' => 125],
        ];

        // Truncate existing and insert fresh data
        DB::table('gallery_images')->truncate();
        DB::table('gallery_images')->insert($images);

        $this->command->info('Gallery images seeded successfully: '.count($images).' images.');
    }
}
