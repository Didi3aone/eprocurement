<title>Document</title>
<style type="text/css" media="print">
    * { display: none; }
</style>
<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
<center><div class="PrintMessage">
    
</center>
<div id="AllContent">
    <center>
        <div>
            <button id="prev">Previous</button>
            <button id="next">Next</button>
            <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
        </div>
        <canvas id="the-canvas" width="1000" height="150" style="border:1px solid #d3d3d3;"></canvas>
    </center>
</div>

<?php $__env->startSection('scripts'); ?>
    ##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

    <script>
        if ('matchMedia' in window) {
            // Chrome, Firefox, and IE 10 support mediaMatch listeners
            window.matchMedia('print').addListener(function(media) {
                if (media.matches) {
                    beforePrint();
                } else {
                    // Fires immediately, so wait for the first mouse movement
                    $(document).one('mouseover', afterPrint);
                }
            });
        } else {
            // IE and Firefox fire before/after events
            $(window).on('beforeprint', beforePrint);
            $(window).on('afterprint', afterPrint);
        }

        function beforePrint() {
            $("#AllContent").hide();
            $(".PrintMessage").show();
        }

        function afterPrint() {
            $(".PrintMessage").hide();
            $("#AllContent").show();
        }
    </script>
<?php $__env->stopSection(); ?>
<script>
    document.addEventListener("contextmenu", function(e){
        e.preventDefault();
    }, false);
    // If absolute URL from the remote server is provided, configure the CORS
    // header on that server.
    var url = '<?php echo e(URL::asset('master-document/'.$path)); ?>';
    // console.log(url);
    // Loaded via <script> tag, create shortcut to access PDF.js exports.
    var pdfjsLib = window['pdfjs-dist/build/pdf'];
    // The workerSrc property shall be specified.
    pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

    var pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 0.8,
        canvas = document.getElementById('the-canvas'),
        ctx = canvas.getContext('2d');

    /**
    * Get page info from document, resize canvas accordingly, and render page.
    * @param  num Page number.
    */
    function renderPage(num) {
        pageRendering = true;
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {
            var viewport = page.getViewport({scale: scale});
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Render PDF page into canvas context
            var renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            var renderTask = page.render(renderContext);

            // Wait for rendering to finish
            renderTask.promise.then(function() {
                pageRendering = false;
                if (pageNumPending !== null) {
                    // New page rendering is pending
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });
        // Update page counters
        document.getElementById('page_num').textContent = num;
    }

    /**
    * If another page rendering in progress, waits until the rendering is
    * finised. Otherwise, executes rendering immediately.
    */
    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    /**
    * Displays previous page.
    */
    function onPrevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }
    document.getElementById('prev').addEventListener('click', onPrevPage);

    /**
    * Displays next page.
    */
    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }
    document.getElementById('next').addEventListener('click', onNextPage);

    /**
    * Asynchronously downloads PDF.
    */
    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById('page_count').textContent = pdfDoc.numPages;
        // Initial/first page rendering
        renderPage(pageNum);
    });
</script><?php /**PATH /Users/whoami/Sites/portalenesis/resources/views/admin/master-document/document/preview-pdf.blade.php ENDPATH**/ ?>