/**
 * WhatsApp Click Tracking Script
 * 
 * Script ini akan otomatis mendeteksi semua tombol WhatsApp di halaman
 * dan mengirim tracking data ke server sebelum redirect ke WhatsApp
 */

(function() {
    'use strict';

    // Konfigurasi
    const CONFIG = {
        trackingUrl: '/watracking/track',
        waPattern: /wa\.me|api\.whatsapp\.com/i,
        debug: true // Set true untuk development - ENABLED for troubleshooting
    };

    /**
     * Log debug message
     */
    function debugLog(message, data) {
        if (CONFIG.debug) {
            console.log('[WA Tracker]', message, data || '');
        }
    }

    /**
     * Get page name from URL
     */
    function getPageName() {
        const path = window.location.pathname;
        
        // Extract page name
        if (path === '/' || path === '/index.php') {
            return 'index';
        }
        
        // Extract from pages/menu/...
        const match = path.match(/pages\/menu\/([^\/]+)\.php/);
        if (match) {
            return match[1];
        }
        
        // Extract from assesoris/...
        const assMatch = path.match(/assesoris\/([^\/]+)\.php/);
        if (assMatch) {
            return 'assesoris-' + assMatch[1];
        }
        
        // Default
        return path.replace(/\//g, '-').replace('.php', '') || 'unknown';
    }

    /**
     * Determine button type from element
     */
    function getButtonType(element) {
        const classList = element.className.toLowerCase();
        const id = element.id ? element.id.toLowerCase() : '';
        
        if (classList.includes('sticky') || id.includes('sticky')) {
            return 'sticky';
        }
        if (classList.includes('footer') || id.includes('footer')) {
            return 'footer';
        }
        if (classList.includes('inline') || id.includes('inline')) {
            return 'inline';
        }
        
        // Check parent elements
        let parent = element.parentElement;
        let depth = 0;
        while (parent && depth < 3) {
            const parentClass = parent.className ? parent.className.toLowerCase() : '';
            if (parentClass.includes('sticky')) return 'sticky';
            if (parentClass.includes('footer')) return 'footer';
            parent = parent.parentElement;
            depth++;
        }
        
        return 'standard';
    }

    /**
     * Send tracking data to server and redirect after completion
     */
    function trackClick(pageName, pageUrl, buttonType, redirectUrl) {
        debugLog('Sending tracking data...', { pageName, pageUrl, buttonType });

        const data = new FormData();
        data.append('page_name', pageName);
        data.append('page_url', pageUrl);
        data.append('button_type', buttonType);

        const trackingUrl = window.location.origin + CONFIG.trackingUrl;
        debugLog('Tracking URL:', trackingUrl);

        // Use fetch with keepalive to ensure request completes
        fetch(trackingUrl, {
            method: 'POST',
            body: data,
            keepalive: true
        })
        .then(response => {
            debugLog('Response status:', response.status);
            return response.json();
        })
        .then(result => {
            debugLog('Tracking success!', result);
        })
        .catch(err => {
            console.error('[WA Tracker] Error:', err);
            debugLog('Tracking error', err);
        })
        .finally(() => {
            // Always redirect after tracking (success or fail)
            // Small delay to ensure request is sent
            setTimeout(() => {
                debugLog('Redirecting to WhatsApp...', redirectUrl);
                window.location.href = redirectUrl;
            }, 100);
        });
    }

    /**
     * Handle WhatsApp link click
     */
    function handleWaClick(event) {
        const link = event.currentTarget;
        const href = link.getAttribute('href');
        
        // Validate it's a WA link
        if (!CONFIG.waPattern.test(href)) {
            return true;
        }

        // PREVENT default redirect - we'll do it manually after tracking
        event.preventDefault();

        debugLog('WhatsApp link clicked', href);

        // Get tracking info
        const pageName = getPageName();
        const pageUrl = window.location.href;
        const buttonType = getButtonType(link);

        // Track the click, then redirect
        trackClick(pageName, pageUrl, buttonType, href);

        // Return false to prevent any default action
        return false;
    }

    /**
     * Initialize tracking on all WhatsApp links
     */
    function initTracking() {
        // Find all links that go to WhatsApp
        const allLinks = document.querySelectorAll('a[href]');
        let trackedCount = 0;

        allLinks.forEach(link => {
            const href = link.getAttribute('href');
            
            if (href && CONFIG.waPattern.test(href)) {
                // Add click listener
                link.addEventListener('click', handleWaClick);
                trackedCount++;
                
                debugLog('Link tracked', {
                    href: href,
                    type: getButtonType(link)
                });
            }
        });

        debugLog(`Initialized tracking on ${trackedCount} WhatsApp links`);

        // Setup mutation observer for dynamically added links
        if (window.MutationObserver) {
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === 1) { // Element node
                            // Check if the node itself is a WA link
                            if (node.tagName === 'A') {
                                const href = node.getAttribute('href');
                                if (href && CONFIG.waPattern.test(href)) {
                                    node.addEventListener('click', handleWaClick);
                                    debugLog('Dynamic link tracked', href);
                                }
                            }
                            // Check for WA links in children
                            const waLinks = node.querySelectorAll('a[href*="wa.me"], a[href*="whatsapp"]');
                            waLinks.forEach(link => {
                                link.addEventListener('click', handleWaClick);
                                debugLog('Dynamic child link tracked', link.href);
                            });
                        }
                    });
                });
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }
    }

    /**
     * Initialize when DOM is ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTracking);
    } else {
        // DOM already loaded
        initTracking();
    }

    // Also init on window load for safety
    window.addEventListener('load', function() {
        // Re-check for any missed links
        setTimeout(initTracking, 500);
    });

})();
