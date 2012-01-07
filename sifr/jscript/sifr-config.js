/**
 * Project:     Footprint - Project Collaboration for Web Designers
 *    File:     sifr-config.js
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * @link http://www.footprintapp.com/
 * @copyright 2007-2009 Webstrong Ltd
 * @author Iarfhlaith Kelly <ik at webstrong dot ie>
 * @package Footprint
 * @version 1.0
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. http://www.footprintapp.com/forums
 *
 */
// Point sifr to the flash folder
var futuraBT = { src: '/sifr/flash/futuraBT.swf' };

// Next, activate sIFR:
sIFR.activate(futuraBT);

// Finally, apply the CSS to the sifr'd text
sIFR.replace(futuraBT, {
  selector: '.container h1',
  wmode: 'transparent',
  css: '.sIFR-root { font-size:43px;color:#ffffff; }'
});

sIFR.replace(futuraBT, {
    selector: '.whatItDoes h2',
    forceSingleLine: true,
    // ratios: [8,1.41,11,1.31,15,1.29,25,1.25,28,1.23,32,1.22,33,1.23,43,1.22,61,1.21,64,1.2,65,1.21,112,1.2,113,1.19,115,1.2,118,1.19,122,1.2,124,1.19,1.2],
    css: [
        '.sIFR-root { font-size:18px;color:#ffffff; }',
        'a {}',
        'a:hover {}'
        ],
    wmode: 'transparent',
    tuneWidth: '5',
    forceWidth: true

});