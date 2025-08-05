
    <div class="container-fluid bg-light">
        <div class="groups-section">
            <!-- Groups Header -->
            <div class="groups-header">
                <h3 class="groups-title">Groups you may like</h3>
                <a href="#" class="see-more-link">See more</a>
            </div>
            
            <!-- Groups Container -->
            <div class="groups-wrapper">
                <div class="groups-container">
                    <div class="groups-row">
                        <?php
                        // Array of group data
                        $groups = [
                            [
                                'name' => 'IT news',
                                'members' => '69.9k members',
                                'image' => 'assets/img/group.jpg'
                            ],
                            [
                                'name' => 'Tech group',
                                'members' => '45.2k members',
                                'image' => 'assets/img/group.jpg'
                            ],
                            [
                                'name' => 'Group',
                                'members' => '32.1k members',
                                'image' => 'assets/img/group.jpg'
                            ],
                            [
                                'name' => 'Essential staff',
                                'members' => '28.7k members',
                                'image' => 'assets/img/group.jpg'
                            ],
                            [
                                'name' => 'Health group',
                                'members' => '15.3k members',
                                'image' => 'assets/img/group.jpg'
                            ],
                            [
                                'name' => 'Everyday news',
                                'members' => '12.8k members',
                                'image' => 'assets/img/group.jpg'
                            ],
                            [
                                'name' => 'Computer science',
                                'members' => '8.9k members',
                                'image' => 'assets/img/group.jpg'
                            ]
                        ];
                        
                        // Loop through groups using for loop
                        foreach ($groups as $group){
                             $group_image = $group['image'];
                            echo '<div class="group-card">';
                            echo '<div class="group-image" style="background-image: url('.$group_image.')"></div>';
                            echo '<div class="group-content">';
                            echo '<div class="group-name">' . $group['name'] . '</div>';
                            echo '<div class="group-members">' . $group['members'] . '</div>';
                            echo '<button class="join-button">Join</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Navigation Arrows -->
                <div class="nav-arrow nav-arrow-left">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="nav-arrow nav-arrow-right">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    </div>
