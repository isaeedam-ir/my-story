document.addEventListener('DOMContentLoaded', function() {
    const nodes = document.querySelectorAll('.my-story');
    
    nodes.forEach(node => {
        const stories = [];
        const storyElements = node.querySelectorAll('.storyData');

        const backNative = node.dataset.backNative === 'true';
        const previousTap = node.dataset.previousTap === 'true';
        const autoFullScreen = node.dataset.autoFullScreen === 'true';
        const avatars = node.dataset.avatars === 'true';
        const paginationArrows = node.dataset.paginationArrows === 'true';
        const cubeEffect = node.dataset.cubeEffect === 'true';
        const direction = node.dataset.direction === 'true';
        const backButton = node.dataset.backButton === 'true';

        storyElements.forEach(storyElement => {
            const storyId = storyElement.getAttribute('data-id');
            const storyPhoto = storyElement.getAttribute('data-photo');
            const storyName = storyElement.getAttribute('data-name');
            const items = [];

            const storyItems = storyElement.querySelectorAll('.storyItem');
   
            const setupElementorObserver = () => {
                const targetNode = document.body;
                const observer = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        mutation.removedNodes.forEach((node) => {
                            if (node.classList && node.classList.contains('my-story')) {
                                localStorage.removeItem('timestampGenerator');
                            }
                        });
                    });
                });
                
                observer.observe(targetNode, {
                    childList: true,
                    subtree: true
                });
            };
                
            if (document.readyState === 'complete') {
                setupElementorObserver();
            } else {
                window.addEventListener('load', setupElementorObserver);
            }

            const createTimestampGenerator = () => {
                const storedData = localStorage.getItem('timestampGenerator');
                let initialTime, counter;
              
                if (storedData) {
                    const { savedInitialTime, savedCounter } = JSON.parse(storedData);
                    initialTime = savedInitialTime;
                    counter = savedCounter;
                } else {
                    initialTime = Math.floor(Date.now() / 1000);
                    counter = 0;
                    localStorage.setItem('timestampGenerator', JSON.stringify({
                        savedInitialTime: initialTime,
                        savedCounter: counter
                    }));
                }
              
                return () => {
                    counter++;
                    localStorage.setItem('timestampGenerator', JSON.stringify({
                        savedInitialTime: initialTime,
                        savedCounter: counter
                    }));
                    return initialTime + counter;
                };
            };                              
            const timestamp = createTimestampGenerator();

            storyItems.forEach(item => {
                const itemId = item.getAttribute('data-id');
                const itemType = item.getAttribute('data-type');
                const itemLength = item.getAttribute('data-length');
                const itemSrc = item.getAttribute('data-src');
                const itemPreview = item.getAttribute('data-preview');
                const itemLink = item.getAttribute('data-link');
                const itemLinkText = item.getAttribute('data-linkText');

                items.push({
                    id: itemId,
                    type: itemType,
                    length: parseInt(itemLength, 10),
                    src: itemSrc,
                    preview: itemPreview,
                    link: itemLink,
                    linkText: itemLinkText,
                    time: timestamp()
                });
            });

            stories.push({
                id: storyId,
                photo: storyPhoto,
                name: storyName,
                time: timestamp(),
                items: items
            });
        });

        window.Zuck(node.querySelector('#stories'), {
            backNative: backNative,
            previousTap: previousTap,
            skin: 'snapgram',
            autoFullScreen: autoFullScreen,
            avatars: avatars,
            paginationArrows: paginationArrows,
            list: false,
            cubeEffect: cubeEffect,
            localStorage: true,
            rtl: direction,
            backButton: backButton,
            stories: stories,
            language: {
                unmute: zuckTranslations.unmute,
                keyboardTip: zuckTranslations.keyboardTip,
                visitLink: zuckTranslations.visitLink,
                time: zuckTranslations.time
            }
        });

    });
});
