export function useLoadingScreen()
{
  // Método para mostrar la pantalla de carga
  const showLoading = () => {
    this.isLoading = true;
  }
  // Método para ocultar la pantalla de carga
  const hideLoading = () => {
    this.isLoading = false;
  }

  return {
    showLoading,
    hideLoading
  }
}

