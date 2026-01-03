<?php
/**
 * 講座カードテンプレート
 * 
 * @package NekoFreaksUniv
 */

$status = nfu_get_field( 'lecture_status' );
$professor = nfu_get_field( 'main_professor' );
$progress = nfu_get_lecture_progress( get_the_ID() );
?>

<article class="lecture-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow" data-date="<?php echo get_the_date('U'); ?>">
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="card-thumbnail h-48 overflow-hidden">
            <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover transition-transform duration-300')); ?>
        </div>
    <?php else : ?>
        <div class="card-thumbnail bg-gradient-to-br from-blue-400 to-purple-500 h-48 flex items-center justify-center">
            <i class="fas fa-book text-6xl"></i>
        </div>
    <?php endif; ?>
    
    <div class="card-content p-4">
        <div class="flex justify-between items-start mb-2">
            <span class="status-badge inline-block px-2 py-1 text-xs rounded-full <?php echo $status === '開講中' ? 'bg-green-100 text-green-800' : ($status === '完結' ? 'bg-gray-100 text-gray-600' : 'bg-yellow-100 text-yellow-800'); ?>">
                <?php echo esc_html( $status ?: '準備中' ); ?>
            </span>
            <?php if ( $professor ) : 
                $professor_data = nfu_get_professor_by_id( $professor );
                $professor_name = $professor_data ? $professor_data['name'] : nfu_get_professor_name( $professor );
                $professor_position = $professor_data && !empty($professor_data['position']) ? $professor_data['position'] : '';
            ?>
                <span class="professor-badge <?php echo esc_attr( nfu_get_professor_class( $professor ) ); ?> text-xs px-2 py-1 rounded">
                    <?php 
                    echo esc_html( $professor_name );
                    if ( $professor_position ) {
                        echo '（' . esc_html( $professor_position ) . '）';
                    }
                    ?>
                </span>
            <?php endif; ?>
        </div>
        
        <h3 class="card-title text-lg font-bold mb-2">
            <a href="<?php the_permalink(); ?>" class="text-gray-800 hover:text-blue-600 transition-colors">
                <?php the_title(); ?>
            </a>
        </h3>
        
        <p class="card-excerpt text-sm text-gray-600 mb-3">
            <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
        </p>
        
        <?php if ( $status === '開講中' || $status === '完結' ) : ?>
            <div class="progress-section" data-lecture-id="<?php echo get_the_ID(); ?>">
                <div class="progress-bar bg-gray-200 rounded-full h-2 mb-2">
                    <div class="progress-fill bg-gradient-to-r from-blue-400 to-purple-500 h-full rounded-full transition-all" 
                         style="width: <?php echo $progress['percentage']; ?>%"
                         data-progress-bar="<?php echo get_the_ID(); ?>"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500">
                    <span data-progress-text="<?php echo get_the_ID(); ?>">進捗: <?php echo $progress['published']; ?>/<?php echo $progress['total']; ?>回</span>
                    <span data-completion-text="<?php echo get_the_ID(); ?>"><?php echo $progress['percentage']; ?>%完了</span>
                </div>
                
                <!-- 完了バッジ（100%時に表示） -->
                <div class="completion-badge hidden mt-2" data-completion-badge="<?php echo get_the_ID(); ?>">
                    <div class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                        <i class="fas fa-certificate mr-1"></i>
                        講座完了！
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="card-footer mt-3 pt-3 border-t border-gray-200 flex justify-between items-center">
            <?php
            $terms = get_the_terms( get_the_ID(), 'theme_category' );
            if ( $terms && ! is_wp_error( $terms ) ) : ?>
                <div class="card-tags">
                    <?php foreach ( array_slice($terms, 0, 2) as $term ) : ?>
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded mr-1">
                            <?php echo esc_html( $term->name ); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <button class="favorite-button text-gray-400 hover:text-red-500 transition-colors" 
                    data-lecture-id="<?php echo get_the_ID(); ?>"
                    data-lecture-title="<?php echo esc_attr(get_the_title()); ?>">
                <span class="favorite-icon">🤍</span>
            </button>
        </div>
    </div>
</article>