<!DOCTYPE html>
<html lang="ru">
<head>
  <title>Cart</title>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="current_url" content="{{  route('cart.index') }}">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div class='d-flex flex-column p-2'>
        <div class='d-flex flex-column justify-content-center align-items-center p-2'>
            <div>
                <h1 class="">Корзина</h1>
            </div>
            <div lass='align-items-center'>
                <div class="alert alert-danger" role="alert" hidden></div>
            </div>
        </div>
        <div class='d-flex flex-row justify-content-center p-2'>
            <button type="button"
                    class="btn btn-primary m-2 btn-page"
                    data-url="{{  route('items.index') }}"
                    >
                    Товары
            </button>
            <button type="button"
                    class="btn btn-primary m-2 btn-page"
                    data-url="{{  route('orders.index') }}"
                    >
                    Заказы
            </button>
            <button type="button"
                    class="btn btn-secondary m-2"
                    data-url="{{  route('logout') }}"
                    >
                    Выход
            </button>
        </div>
        <div class='d-flex row flex-row justify-content-center'>
            @if( count($items) )
            <div class="col-auto w-75">
                <div>
                    <table class="table table-striped table-hover w-100">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div class='d-flex flex-row justify-content-center'>
                                    #
                                </div>
                            </th>
                            <th scope="col">
                                <div class='d-flex flex-row justify-content-center'>
                                    Название
                                </div>
                            </th>
                            <th scope="col">
                                <div class='d-flex flex-row justify-content-center'>
                                    Количество
                                </div>
                            </th>
                            <th scope="col">
                                <div class='d-flex flex-row justify-content-center'>
                                    Цена
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($items); $i++)
                            <tr>
                                <th>
                                    <div class='d-flex flex-row justify-content-center'>
                                        {{ $i+1 }}
                                    </div>
                                </th>
                                <td>
                                    <div class='d-flex flex-row justify-content-center'>
                                        {{ $items[$i]['item_title'] }}
                                    </div>
                                </td>
                                <td>
                                    <div class='d-flex flex-row justify-content-center'>
                                        {{ $items[$i]['item_count'] }}
                                    </div>
                                </td>
                                <td>
                                    <div class='d-flex flex-row justify-content-center'>
                                        {{ $items[$i]['price_all'] }}
                                    </div>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>
                                    <div class='d-flex flex-row justify-content-center'>
                                    </div>
                                </th>
                                <td>
                                    <div class='d-flex flex-row justify-content-center'>
                                    </div>
                                </td>
                                <td>
                                    <div class='d-flex flex-row justify-content-center'>
                                    </div>
                                </td>
                                <td>
                                    <div class='d-flex flex-row justify-content-center'>
                                        {{ $price_all }}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div>
                    <button type="button"
                            class="btn btn-primary btn-delete"
                            data-url={{ route('cart.destroy_by_current_user') }}
                            >Удалить
                    </button>
                    <button type="button"
                            class="btn btn-primary btn-add-order"
                            data-url={{route('orders.store')}}
                            >
                            Оформить заказ
                    </button>
                </div>
            </div>
            @else
            <div class="d-flex flex-row justify-content-center w-75" style='background-color:rgba(211, 193, 191, 0.16)'>
                <h2 class="">Корзина пустая</h2>
            </div>
            @endif
        </div>
    </div>
</body>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let btnsPage = document.querySelectorAll(".btn-page");
    for(let i=0; i < btnsPage.length; ++i)
    {
        btnsPage[i].onclick = function(event)
        {
            let url = event.target.getAttribute('data-url');
            window.location.href = url;
        };
    }

    let btnsDelete = document.querySelector(".btn-delete");
    if(btnsDelete)
    {
        btnsDelete.onclick = function(event)
        {
            let divAllert = document.querySelector(".alert");
            divAllert.setAttribute('hidden', 'hidden');

            let url = event.target.getAttribute('data-url');
            console.log(url)
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify('')
            })
            .then(response =>
            {
                if (response.ok)
                {
                    divAllert.setAttribute('class', 'alert alert-success');
                    divAllert.removeAttribute('hidden');
                    divAllert.innerHTML = 'Корзина очищена';

                    const url = document.querySelector('meta[name="current_url"]').getAttribute('content');
                    window.location.href = url;
                }
                else
                {
                    let errMsg = 'Network response was not ok.';
                    if(response.error)
                    {
                        errMsg = response.error;
                    }
                    divAllert.setAttribute('class', 'alert alert-danger');
                    divAllert.removeAttribute('hidden');
                    divAllert.innerHTML = errMsg
                    throw new Error(errMsg);
                }
            })
            .catch(error => {
                console.error('There was a problem with your fetch operation:', error);
            });
        };
    }

    let btnsAddOrder = document.querySelector(".btn-add-order");
    if(btnsAddOrder)
    {
        btnsAddOrder.onclick = function(event)
        {
            let divAllert = document.querySelector(".alert");
            divAllert.setAttribute('hidden', 'hidden');

            let url = event.target.getAttribute('data-url');
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify('')
            })
            .then(response =>
            {
                console.log(response);
                if (response.ok)
                {
                    divAllert.setAttribute('class', 'alert alert-success');
                    divAllert.removeAttribute('hidden');
                    divAllert.innerHTML = 'Заказ добавлен';

                    const url = document.querySelector('meta[name="current_url"]').getAttribute('content');
                    window.location.href = url;
                }
                else
                {
                    console.log(divAllert);
                    let errMsg = 'Network response was not ok.';
                    if(response.error)
                    {
                        errMsg = response.error;
                    }
                    divAllert.setAttribute('class', 'alert alert-danger');
                    divAllert.removeAttribute('hidden');
                    divAllert.innerHTML = errMsg
                    throw new Error(errMsg);
                }
            })
            .catch(error => {
                console.error('There was a problem with your fetch operation:', error);
            });
        };
    }

</script>
</html>
