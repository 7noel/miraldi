<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<div class="text-center">
					<h5 class="font-weight-bold">Ultimos Movimientos</h5>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body table-responsive">
				<div class="font-weight-bold" id="codigo_descripcion"></div>
				<div class="font-weight-bold" id="stock"></div>
				<div class="font-weight-bold" id="stock_disponible"></div>
				<br>
				<table class="table table-hover table-sm">
					<thead>
						<tr>
							<th class="text-center">Pedido</th>
							<th class="text-center">Picking</th>
							<th class="text-center">F_Picking</th>
							<th class="text-center">Cantidad</th>
							<th class="text-center">Factura</th>
							<th class="text-center">F_Factura</th>
							<th>Usuario</th>
							<th>Cliente</th>
						</tr>
					</thead>
					<tbody id="table-movimientos">
						<tr>
							<td>pedido</td>
							<td>picking</td>
							<td>fecha1</td>
							<td>cantidad</td>
							<td>factura</td>
							<td>fecha2</td>
							<td>usuario</td>
							<td>cliente</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>