<!DOCTYPE html>
<html lang="ru">
<head>
  <title>Items</title>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="current_url" content="{{  route('items.index') }}">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div class='d-flex flex-column p-2'>
        <div class='d-flex flex-column justify-content-center align-items-center p-2'>
            <div>
                <h1 class="">Товары</h1>
            </div>
            <div lass='align-items-center'>
                <div class="alert alert-danger" role="alert" hidden></div>
            </div>
        </div>
        <div class='d-flex flex-row justify-content-center p-2 btn-page'>
            <button type="button"
                    class="btn btn-primary m-2"
                    data-url="{{  route('orders.index') }}"
                    >
                    Заказы
            </button>
            <button type="button"
                    class="btn btn-primary m-2"
                    data-url="{{  route('cart.index') }}"
                    >
                    Корзина
            </button>
            <button type="button"
                    class="btn btn-secondary m-2"
                    data-url="{{  route('logout') }}"
                    >
                    Выход
            </button>
        </div>
        <div class='d-flex row flex-row justify-content-center'>
            <div class="col-auto w-75">
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
                            Цена
                        </div>
                    </th>
                    <th scope="col">
                        <div class='d-flex flex-row justify-content-center'>
                            Количество
                        </div>
                    </th>
                    <th scope="col">
                        <div class='d-flex flex-row justify-content-center'>
                            Кнопка
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
                                {{ $items[$i]['title'] }}
                            </div>
                        </td>
                        <td>
                            <div class='d-flex flex-row justify-content-center'>
                                {{ $items[$i]['price'] }}
                            </div>
                        </td>
                        <td>
                            <div class='d-flex flex-row justify-content-center'>
                                {{ $items[$i]['count'] }}
                            </div>
                        </td>
                        <td>
                          <div class='d-flex flex-row justify-content-center div-add-to-card'
                                data-count="{{ $items[$i]['count'] }}">
                            <input type="number"
                                      class='input_num  m-2'
                                      min="1" max="{{ $items[$i]['count'] }}"
                                      value="1"
                                      pattern="^[0-9]*$"
                                      data-id='{{ $items[$i]['id'] }}'>
                            <button type="button"
                                      class="btn btn-primary add-card  m-2"
                                      data-id='{{ $items[$i]['id'] }}'
                                      data-url='{{route('cart.store')}}'
                                      >
                                      Добавить в корзину
                            </button>
                          </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        </div>
    </div>
</body>
<script>

    let divsAddToCard = document.querySelectorAll(".div-add-to-card");
    for(let i=0; i < divsAddToCard.length; ++i)
    {
        let count_items = divsAddToCard[i].getAttribute('data-count');
        if( count_items <= 0 )
        {
            console.log(count_items)
            let childNodes = divsAddToCard[i].getElementsByTagName('*');
            for (var node of childNodes) {
                node.disabled = true;
            }
        }
    }

    let btnsPage = document.querySelectorAll(".btn-page");
    for(let i=0; i < btnsPage.length; ++i)
    {
        btnsPage[i].onclick = function(event)
        {
            let url = event.target.getAttribute('data-url');
            window.location.href = url;
        };
    }

    let list = document.querySelectorAll(".input_num");
    for(let i=0; i < list.length; ++i)
    {
        list[i].addEventListener('change', (event) =>
        {
            if( event.target.value < event.target.attributes.min.value )
            {
                event.target.value = event.target.attributes.min.value;
            }
            else if( event.target.value > event.target.attributes.max.value )
            {
                event.target.value = event.target.attributes.max.value;
            }
        });
    }

    let btns = document.querySelectorAll(".add-card");
    for(let i=0; i < btns.length; ++i)
    {
        btns[i].onclick = function(event)
        {
            let idItem = event.target.getAttribute('data-id');
            let url = event.target.getAttribute('data-url');
            let elCount = document.querySelector(`input[data-id='${idItem}']`);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const data = {
                id: idItem,
                count: elCount.value,
            };

            let divAllert = document.querySelector(".alert");
            divAllert.setAttribute('hidden', 'hidden');

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(data)
            })
            .then(response =>
            {
                if (response.ok)
                {
                  response.json().then(function(data)
                  {
                    divAllert.removeAttribute('hidden');
                    if(data.error)
                    {
                        divAllert.setAttribute('class', 'alert alert-danger');
                        divAllert.innerHTML = data.error;
                        return;
                    }
                    divAllert.setAttribute('class', 'alert alert-success');
                    divAllert.innerHTML = 'Успешно добавлено';

                    const url = document.querySelector('meta[name="current_url"]').getAttribute('content');
                    window.location.href = url;
                  });
                }
                else
                {
                    let errMsg = 'Network response was not ok.';
                    if(data.error)
                    {
                        errMsg = data.error;
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
