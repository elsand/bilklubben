<dl class="clearfix">
<dt>Totalpris for leieperioden:</dt><dd><span class="points">{{ $totalprice }}</span></dd>
@if ($discount)
<dt class="medium">Fullpris:</dt><dd class="medium"><span class="points">{{ $subtotalprice }}</span></dd>
<dt class="medium">Rabatt:</dt><dd class="medium"><span class="points">{{ $discount }}</span></dd>
@endif
</dl>
