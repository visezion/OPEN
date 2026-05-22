<script src="<?php echo e(asset('js/jquery.min.js')); ?> "></script>
<script src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        generatePDF();
    });

    function generatePDF() {
        var element = document.getElementById('boxes');
        var opt = {
            margin: 0.5,
            filename: '<?php echo e(App\Models\Proposal::proposalNumberFormat($proposal->proposal_id,$proposal->created_by)); ?>',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, dpi: 72, letterRendering: true },
            jsPDF: { unit: 'in', format: 'A4' },
            pagebreak: { avoid: ['tr', 'td'] }
        };

        html2pdf().set(opt).from(element).save().then(() => {
            closeWindow();
        });
    }


    function closeWindow() {
        setTimeout(function() {
            window.close();
        }, 1000);
    }
</script>

<?php /**PATH C:\xampp\htdocs\OPEN\resources\views\proposal\script.blade.php ENDPATH**/ ?>