<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Recipes extends Component
{
    public $searchTerm = '';
    public $selectedCategory = 'all';
    public $recipes = [];

    public function mount()
    {
        $this->recipes = [
            [
                'id' => 1,
                'title' => 'Spicy Masala Makhana',
                'description' => 'Crispy roasted fox nuts with aromatic Indian spices - perfect evening snack',
                'prep_time' => '10 mins',
                'cook_time' => '15 mins',
                'servings' => '4',
                'difficulty' => 'Easy',
                'category' => 'snacks',
                'image' => 'https://images.unsplash.com/photo-1567188040759-fb8a883dc6d8?w=400&h=300&fit=crop',
                'ingredients' => [
                    '2 cups makhana (fox nuts)',
                    '2 tbsp ghee',
                    '1 tsp cumin seeds',
                    '1/2 tsp red chili powder',
                    '1/2 tsp turmeric powder',
                    '1 tsp garam masala',
                    '1/2 tsp chaat masala',
                    'Salt to taste',
                    'Fresh coriander leaves'
                ],
                'instructions' => [
                    'Heat ghee in a large pan over medium heat',
                    'Add cumin seeds and let them splutter',
                    'Add makhana and roast for 5-7 minutes until crispy',
                    'Add all spices and mix well',
                    'Roast for another 2-3 minutes',
                    'Garnish with fresh coriander and serve hot'
                ],
                'tips' => 'Ensure makhana is completely crispy before adding spices for best texture'
            ],
            [
                'id' => 2,
                'title' => 'Makhana Kheer',
                'description' => 'Creamy and rich dessert made with fox nuts, milk, and cardamom',
                'prep_time' => '15 mins',
                'cook_time' => '30 mins',
                'servings' => '6',
                'difficulty' => 'Medium',
                'category' => 'desserts',
                'image' => 'https://images.unsplash.com/photo-1563205987-b85bb3603975?w=400&h=300&fit=crop',
                'ingredients' => [
                    '1 cup makhana',
                    '4 cups full-fat milk',
                    '1/2 cup sugar',
                    '4-5 green cardamom pods',
                    '10-12 almonds, chopped',
                    '10-12 pistachios, chopped',
                    '2 tbsp ghee',
                    'Pinch of saffron'
                ],
                'instructions' => [
                    'Roast makhana in ghee until crispy and grind coarsely',
                    'Boil milk in a heavy-bottomed pan',
                    'Add ground makhana and cook for 15 minutes',
                    'Add sugar, cardamom powder, and saffron',
                    'Cook until thickened, stirring occasionally',
                    'Garnish with nuts and serve warm or chilled'
                ],
                'tips' => 'Stir continuously to prevent sticking to the bottom'
            ],
            [
                'id' => 3,
                'title' => 'Makhana Curry',
                'description' => 'Rich and creamy curry with fox nuts in tomato-cashew gravy',
                'prep_time' => '20 mins',
                'cook_time' => '25 mins',
                'servings' => '4',
                'difficulty' => 'Medium',
                'category' => 'main-course',
                'image' => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=400&h=300&fit=crop',
                'ingredients' => [
                    '2 cups makhana',
                    '3 tbsp ghee',
                    '2 large tomatoes',
                    '1/4 cup cashews',
                    '1 large onion, chopped',
                    '1 tbsp ginger-garlic paste',
                    '1 tsp cumin seeds',
                    '1 tsp coriander powder',
                    '1/2 tsp red chili powder',
                    '1/2 cup heavy cream',
                    'Fresh coriander leaves'
                ],
                'instructions' => [
                    'Roast makhana in 1 tbsp ghee until crispy, set aside',
                    'Blend tomatoes and cashews to make smooth paste',
                    'Heat remaining ghee, add cumin seeds',
                    'Add onions and cook until golden',
                    'Add ginger-garlic paste and spices',
                    'Add tomato-cashew paste and cook for 10 minutes',
                    'Add roasted makhana and cream, simmer for 5 minutes'
                ],
                'tips' => 'Don\'t over-cook makhana in curry to maintain texture'
            ],
            [
                'id' => 4,
                'title' => 'Chocolate Makhana',
                'description' => 'Sweet and crunchy chocolate-coated fox nuts - kids favorite!',
                'prep_time' => '15 mins',
                'cook_time' => '10 mins',
                'servings' => '4',
                'difficulty' => 'Easy',
                'category' => 'desserts',
                'image' => 'https://images.unsplash.com/photo-1548907040-4baa42d10919?w=400&h=300&fit=crop',
                'ingredients' => [
                    '2 cups makhana',
                    '100g dark chocolate',
                    '2 tbsp ghee',
                    '2 tbsp honey',
                    '1/4 cup chopped nuts',
                    'Pinch of sea salt'
                ],
                'instructions' => [
                    'Roast makhana in ghee until crispy',
                    'Melt chocolate in double boiler',
                    'Add honey and mix well',
                    'Coat roasted makhana with chocolate mixture',
                    'Sprinkle nuts and salt',
                    'Spread on parchment paper and let it cool'
                ],
                'tips' => 'Use good quality dark chocolate for best results'
            ],
            [
                'id' => 5,
                'title' => 'Makhana Raita',
                'description' => 'Refreshing yogurt-based side dish with crispy fox nuts',
                'prep_time' => '15 mins',
                'cook_time' => '5 mins',
                'servings' => '4',
                'difficulty' => 'Easy',
                'category' => 'sides',
                'image' => 'https://images.unsplash.com/photo-1594736797933-d0d501ba2fe6?w=400&h=300&fit=crop',
                'ingredients' => [
                    '1 cup makhana',
                    '2 cups thick yogurt',
                    '1 cucumber, diced',
                    '1 small onion, finely chopped',
                    '1 green chili, minced',
                    '1 tsp roasted cumin powder',
                    '1/2 tsp black salt',
                    'Fresh mint leaves',
                    'Regular salt to taste'
                ],
                'instructions' => [
                    'Roast makhana until crispy and break into pieces',
                    'Whisk yogurt until smooth',
                    'Add all vegetables and spices to yogurt',
                    'Mix in roasted makhana pieces',
                    'Garnish with mint leaves',
                    'Serve immediately for best texture'
                ],
                'tips' => 'Add makhana just before serving to keep them crispy'
            ],
            [
                'id' => 6,
                'title' => 'Makhana Tikki',
                'description' => 'Healthy and delicious patties made with fox nuts and vegetables',
                'prep_time' => '25 mins',
                'cook_time' => '15 mins',
                'servings' => '6',
                'difficulty' => 'Medium',
                'category' => 'snacks',
                'image' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=400&h=300&fit=crop',
                'ingredients' => [
                    '1.5 cups makhana, ground',
                    '2 large potatoes, boiled',
                    '1/2 cup green peas',
                    '1 carrot, finely chopped',
                    '2 green chilies, minced',
                    '1 tsp ginger paste',
                    '1 tsp garam masala',
                    '1 tsp coriander powder',
                    'Salt to taste',
                    'Oil for shallow frying'
                ],
                'instructions' => [
                    'Roast and grind makhana coarsely',
                    'Mash potatoes and mix with all vegetables',
                    'Add ground makhana and all spices',
                    'Form into small patties',
                    'Heat oil in pan and shallow fry tikkis',
                    'Cook until golden brown on both sides'
                ],
                'tips' => 'Ensure mixture is not too wet to prevent breaking'
            ],
            [
                'id' => 7,
                'title' => 'Makhana Pulao',
                'description' => 'Aromatic rice dish with fox nuts, vegetables, and fragrant spices',
                'prep_time' => '20 mins',
                'cook_time' => '30 mins',
                'servings' => '6',
                'difficulty' => 'Medium',
                'category' => 'main-course',
                'image' => 'https://images.unsplash.com/photo-1596797038530-2c107229654b?w=400&h=300&fit=crop',
                'ingredients' => [
                    '2 cups basmati rice',
                    '1 cup makhana',
                    '3 tbsp ghee',
                    '4-5 green cardamom',
                    '2 bay leaves',
                    '1 cinnamon stick',
                    '1 large onion, sliced',
                    '1/2 cup mixed vegetables',
                    '3.5 cups water',
                    'Salt to taste'
                ],
                'instructions' => [
                    'Roast makhana in 1 tbsp ghee until crispy',
                    'Soak rice for 30 minutes',
                    'Heat remaining ghee, add whole spices',
                    'Add onions and cook until golden',
                    'Add vegetables and rice, mix gently',
                    'Add water, salt, and roasted makhana',
                    'Cook until rice is done'
                ],
                'tips' => 'Don\'t over-mix to prevent rice from breaking'
            ],
            [
                'id' => 8,
                'title' => 'Makhana Laddu',
                'description' => 'Traditional sweet balls made with fox nuts, jaggery, and ghee',
                'prep_time' => '30 mins',
                'cook_time' => '20 mins',
                'servings' => '8',
                'difficulty' => 'Medium',
                'category' => 'desserts',
                'image' => 'https://images.unsplash.com/photo-1606312619070-d48b4c652a52?w=400&h=300&fit=crop',
                'ingredients' => [
                    '2 cups makhana',
                    '3/4 cup jaggery, grated',
                    '4 tbsp ghee',
                    '1/4 cup mixed nuts, chopped',
                    '1 tsp cardamom powder',
                    '2 tbsp coconut, desiccated'
                ],
                'instructions' => [
                    'Roast makhana in 2 tbsp ghee until crispy',
                    'Cool and grind to fine powder',
                    'Heat remaining ghee, add jaggery',
                    'Cook until jaggery melts and thickens',
                    'Add makhana powder, nuts, and cardamom',
                    'Mix well and form into round laddus',
                    'Roll in coconut and let them cool'
                ],
                'tips' => 'Form laddus while mixture is still warm for easy shaping'
            ]
        ];
    }

    public function getFilteredRecipes()
    {
        $filtered = $this->recipes;

        if ($this->searchTerm) {
            $filtered = array_filter($filtered, function($recipe) {
                return stripos($recipe['title'], $this->searchTerm) !== false ||
                       stripos($recipe['description'], $this->searchTerm) !== false;
            });
        }

        if ($this->selectedCategory !== 'all') {
            $filtered = array_filter($filtered, function($recipe) {
                return $recipe['category'] === $this->selectedCategory;
            });
        }

        return $filtered;
    }

    public function render()
    {
        return view('livewire.public.recipes', [
            'filteredRecipes' => $this->getFilteredRecipes()
        ]);
    }
}
